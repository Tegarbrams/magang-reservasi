<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\BlockedSchedule;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Check if specific time slot is available
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
        ]);

        // 🔧 NORMALISASI FORMAT JAM
        $jamNormalized = substr($request->jam, 0, 5);

        // 🔒 Check blocked schedule (maintenance / auto)
        $isBlocked = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam', $jamNormalized) // 🔧 GUNAKAN FORMAT KONSISTEN
            ->exists();

        if ($isBlocked) {
            return response()->json([
                'available' => false,
                'message' => 'Jadwal tidak tersedia. Silakan pilih waktu lain.'
            ]);
        }

        // 📌 Check existing reservation
        $isBooked = Reservasi::where('ruangan', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->whereRaw('SUBSTRING(jam_check_in, 1, 5) = ?', [$jamNormalized]) // 🔧 COMPARE FORMAT KONSISTEN
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($isBooked) {
            return response()->json([
                'available' => false,
                'message' => 'Ruangan sudah dibooking pada waktu tersebut.'
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Jadwal tersedia'
        ]);
    }

    /**
     * 🔧 PERBAIKAN: Get all available time slots for a specific date and room
     * Return format HH:MM konsisten dengan frontend
     */
    public function getAvailableTimes(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
        ]);

        // ⏰ All possible time slots (08:00 - 18:00) - FORMAT: HH:MM
        $allTimes = [];
        for ($i = 8; $i <= 18; $i++) {
            $allTimes[] = sprintf('%02d:00', $i);
        }

        // 🔒 Blocked schedules (maintenance + auto)
        $blockedSchedules = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->get()
            ->pluck('jam')
            ->map(function($jam) {
                return substr($jam, 0, 5); // 🔧 NORMALISASI: HH:MM only
            })
            ->toArray();

        // 📌 Booked schedules
        $bookedTimes = Reservasi::where('ruangan', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['pending', 'approved'])
            ->get()
            ->pluck('jam_check_in')
            ->map(function($jam) {
                return substr($jam, 0, 5); // 🔧 NORMALISASI: HH:MM only
            })
            ->toArray();

        // Merge dan deduplicate
        $blockedTimes = array_unique(array_merge($blockedSchedules, $bookedTimes));
        $availableTimes = array_diff($allTimes, $blockedTimes);

        return response()->json([
            'status' => true, // 🔧 UBAH ke 'status' untuk konsisten dengan frontend
            'data' => [
                'available_slots' => array_values($availableTimes),
                'unavailable_slots' => array_values($blockedTimes),
            ]
        ]);
    }

    /**
     * Monthly calendar availability
     */
    public function getMonthAvailability(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'month' => 'required|date_format:Y-m',
        ]);

        $startDate = $request->month . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        // Get reservations
        $reservations = Reservasi::where('ruangan', $request->ruangan_id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereIn('status', ['pending', 'approved'])
            ->get(['tanggal', 'jam_check_in'])
            ->groupBy('tanggal')
            ->map(fn ($items) => $items->pluck('jam_check_in')
                ->map(fn($jam) => substr($jam, 0, 5)) // 🔧 NORMALISASI
                ->toArray()
            );

        // Get blocked schedules
        $blockedSchedules = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get(['tanggal', 'jam'])
            ->groupBy('tanggal')
            ->map(fn ($items) => $items->pluck('jam')
                ->map(fn($jam) => substr($jam, 0, 5)) // 🔧 NORMALISASI
                ->toArray()
            );

        $availability = [];
        $current = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        while ($current <= $end) {
            $date = $current->format('Y-m-d');

            $booked = $reservations->get($date, []);
            $blocked = $blockedSchedules->get($date, []);

            // All time slots - FORMAT: HH:MM
            $allTimes = [];
            for ($i = 8; $i <= 18; $i++) {
                $allTimes[] = sprintf('%02d:00', $i);
            }

            $unavailable = array_unique(array_merge($booked, $blocked));
            $availableSlots = count(array_diff($allTimes, $unavailable));

            $availability[] = [
                'date' => $date,
                'available_slots' => $availableSlots,
                'total_slots' => count($allTimes),
                'is_fully_booked' => $availableSlots === 0,
                'booked_times' => array_values($booked),
                'blocked_times' => array_values($blocked),
            ];

            $current->modify('+1 day');
        }

        return response()->json([
            'success' => true,
            'data' => $availability
        ]);
    }
}