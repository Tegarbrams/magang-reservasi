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

        // 🔒 Check blocked schedule (maintenance / auto)
        $isBlocked = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam', $request->jam)
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
            ->where('jam_check_in', $request->jam)
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
     * Get all available time slots for a specific date and room
     */
    public function getAvailableTimes(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
        ]);

        // ⏰ All possible time slots (08:00 - 18:00)
        $allTimes = [];
        for ($i = 8; $i <= 18; $i++) {
            $allTimes[] = sprintf('%02d:00', $i);
        }

        // 🔒 Blocked schedules (maintenance + auto)
        $blockedSchedules = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->pluck('jam')
            ->toArray();

        // 📌 Booked schedules
        $bookedTimes = Reservasi::where('ruangan', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('jam_check_in')
            ->toArray();

        $blockedTimes = array_unique(array_merge($blockedSchedules, $bookedTimes));

        $availableTimes = array_diff($allTimes, $blockedTimes);

        return response()->json([
            'success' => true,
            'available_times' => array_values($availableTimes),
            'blocked_times' => $blockedTimes,
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

        $reservations = Reservasi::where('ruangan', $request->ruangan_id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereIn('status', ['pending', 'approved'])
            ->get(['tanggal', 'jam_check_in'])
            ->groupBy('tanggal')
            ->map(fn ($items) => $items->pluck('jam_check_in')->toArray());

        $blockedSchedules = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get(['tanggal', 'jam'])
            ->groupBy('tanggal')
            ->map(fn ($items) => $items->pluck('jam')->toArray());

        $availability = [];
        $current = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        while ($current <= $end) {
            $date = $current->format('Y-m-d');

            $booked = $reservations->get($date, []);
            $blocked = $blockedSchedules->get($date, []);

            $allTimes = [];
            for ($i = 8; $i <= 18; $i++) {
                $allTimes[] = sprintf('%02d:00', $i);
            }

            $availableSlots = count(array_diff($allTimes, array_merge($booked, $blocked)));

            $availability[] = [
                'date' => $date,
                'available_slots' => $availableSlots,
                'total_slots' => count($allTimes),
                'is_fully_booked' => $availableSlots === 0,
                'booked_times' => $booked,
                'blocked_times' => $blocked,
            ];

            $current->modify('+1 day');
        }

        return response()->json([
            'success' => true,
            'data' => $availability
        ]);
    }
}
