<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlockedSchedule;
use App\Models\Reservasi;
use App\Models\Ruangan;
use Carbon\Carbon;

class AdminScheduleController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::all();
        return view('admin.schedule-management', compact('ruangans'));
    }

    public function getData(Request $request)
    {
        try {
            $request->validate([
                'ruangan_id' => 'required|exists:ruangans,id',
                'month' => 'required|date_format:Y-m'
            ]);

            $ruanganId = $request->ruangan_id;
            $month = $request->month;
            
            $startDate = Carbon::parse($month . '-01')->startOfMonth();
            $endDate = Carbon::parse($month . '-01')->endOfMonth();

            // Get all blocked schedules (manual maintenance)
            $blockedSchedules = BlockedSchedule::where('ruangan_id', $ruanganId)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->with('reservasi')
                ->get();

            // Get all approved/pending reservations
            $reservations = Reservasi::where('ruangan', $ruanganId)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->whereIn('status', ['pending', 'approved'])
                ->get();

            $scheduleData = [];

            // Add blocked schedules
            foreach ($blockedSchedules as $blocked) {
                $label = $blocked->keterangan ?? 'Maintenance';
                $type = $blocked->type === 'auto' ? 'booked' : 'maintenance';

                if ($blocked->type === 'auto' && $blocked->reservasi) {
                    $label = 'Reservasi: ' . $blocked->reservasi->nama;
                }

                $scheduleData[] = [
                    'date' => Carbon::parse($blocked->tanggal)->format('Y-m-d'),
                    'time' => $blocked->jam,
                    'type' => $type,
                    'label' => $label,
                    'id' => $blocked->id,
                    'is_manual' => $blocked->type === 'manual'
                ];
            }

            // Add reservations that aren't in BlockedSchedule yet
            foreach ($reservations as $reservation) {
                $exists = $blockedSchedules->where('reservasi_id', $reservation->id)->count() > 0;
                
                if (!$exists) {
                    $scheduleData[] = [
                        'date' => Carbon::parse($reservation->tanggal)->format('Y-m-d'),
                        'time' => $reservation->jam_check_in,
                        'type' => 'booked',
                        'label' => 'Reservasi: ' . $reservation->nama,
                        'id' => 'res_' . $reservation->id,
                        'is_manual' => false
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => $scheduleData
            ]);

        } catch (\Exception $e) {
            \Log::error('Error getting schedule data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleBlock(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'action' => 'required|in:block,unblock',
            'keterangan' => 'nullable|string'
        ]);

        try {
            if ($request->action === 'block') {
                // Check if there's an existing reservation
                $existingReservation = Reservasi::where('ruangan', $request->ruangan_id)
                    ->where('tanggal', $request->tanggal)
                    ->where('jam_check_in', $request->jam)
                    ->whereIn('status', ['pending', 'approved'])
                    ->exists();

                if ($existingReservation) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak bisa blok manual karena sudah ada reservasi aktif'
                    ], 422);
                }

                // Check if already blocked (auto or manual)
                $existingBlock = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
                    ->where('tanggal', $request->tanggal)
                    ->where('jam', $request->jam)
                    ->exists();

                if ($existingBlock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jadwal ini sudah diblok'
                    ], 422);
                }

                // Create manual block
                BlockedSchedule::create([
                    'ruangan_id' => $request->ruangan_id,
                    'tanggal' => $request->tanggal,
                    'jam' => $request->jam,
                    'keterangan' => $request->keterangan ?? 'Manual Block',
                    'type' => 'manual',
                    'created_by' => auth()->id()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal berhasil diblok'
                ]);

            } else {
                // Unblock - only manual blocks
                $deleted = BlockedSchedule::where('ruangan_id', $request->ruangan_id)
                    ->where('tanggal', $request->tanggal)
                    ->where('jam', $request->jam)
                    ->where('type', 'manual')
                    ->delete();

                if ($deleted) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Blok jadwal berhasil dihapus'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak dapat menghapus blok otomatis dari reservasi'
                    ], 422);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error toggling block: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Auto block when reservation is approved
    public static function blockScheduleOnApprove($reservasi)
    {
        try {
            // Check if already blocked
            $exists = BlockedSchedule::where('ruangan_id', $reservasi->ruangan)
                ->where('tanggal', $reservasi->tanggal)
                ->where('jam', $reservasi->jam_check_in)
                ->exists();

            if ($exists) {
                return true; // Already blocked
            }

            BlockedSchedule::create([
                'ruangan_id' => $reservasi->ruangan,
                'tanggal' => $reservasi->tanggal,
                'jam' => $reservasi->jam_check_in,
                'keterangan' => 'Reservasi: ' . $reservasi->nama . ' (' . $reservasi->nomor_reservasi . ')',
                'type' => 'auto',
                'reservasi_id' => $reservasi->id
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('Error blocking schedule: ' . $e->getMessage());
            return false;
        }
    }

    // Unblock when reservation is cancelled or rejected
    public static function unblockScheduleOnCancelOrReject($reservasi)
    {
        try {
            BlockedSchedule::where('reservasi_id', $reservasi->id)
                ->where('type', 'auto')
                ->delete();

            return true;
        } catch (\Exception $e) {
            \Log::error('Error unblocking schedule: ' . $e->getMessage());
            return false;
        }
    }
}