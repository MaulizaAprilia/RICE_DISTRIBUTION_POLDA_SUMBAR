<?php

namespace App\Http\Controllers\AdminPolsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masyarakat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class PolsekPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user();
        $polres_id = optional($admin->profile)->polres_id;
        $polsek_id = optional($admin->profile)->polsek_id;

        if (!$polres_id || !$polsek_id) {
            return redirect()->back()->with('error', 'Admin tidak memiliki data polres/polsek.');
        }

        $query = Masyarakat::with('user:id,name')
            ->whereHas('user.profile', function ($q) use ($polres_id, $polsek_id) {
                $q->where('polres_id', $polres_id)
                  ->where('polsek_id', $polsek_id);
            })
            ->select('id', 'created_by', 'jumlah_beras', 'foto_ktp', 'created_at', 'polres_id', 'polsek_id')
            ->orderBy('created_at', 'desc');

        // 🔍 Fitur Search dengan filter field
        if ($request->filled('search') && $request->filled('field')) {
            $search = $request->search;
            $field = $request->field;

            $query->where(function ($q) use ($search, $field) {
                switch ($field) {
                    case 'name':
                        $q->whereHas('user', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%");
                        });
                        break;
                    case 'nrp':
                    case 'jabatan':
                    case 'pangkat':
                        $q->whereHas('user.profile', function ($q2) use ($field, $search) {
                            $q2->where($field, 'like', "%{$search}%");
                        });
                        break;
                    case 'jumlah_beras':
                        $q->where('jumlah_beras', 'like', "%{$search}%");
                        break;
                }
            });
        }

        // Filter periode cepat
        if ($request->periode) {
            switch ($request->periode) {
                case 'hari_ini':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'minggu_ini':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        // Filter tanggal manual
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Hitung total beras sesuai filter
        $totalBeras = $query->sum('jumlah_beras');

        // Ambil data dengan pagination
        $masyarakat = $query->paginate(10)->withQueryString();

        return view('adminpolsek.polsekpenjualan', compact('masyarakat', 'totalBeras'));
    }

    public function detail($id)
    {
        $admin = Auth::user();
        $polres_id = optional($admin->profile)->polres_id;
        $polsek_id = optional($admin->profile)->polsek_id;

        if (!$polres_id || !$polsek_id) {
            return redirect()->back()->with('error', 'Admin tidak memiliki data polres/polsek.');
        }

        $masyarakat = Masyarakat::with('user')
            ->whereHas('user.profile', function ($q) use ($polres_id, $polsek_id) {
                $q->where('polres_id', $polres_id)
                  ->where('polsek_id', $polsek_id);
            })
            ->findOrFail($id);

        return view('adminpolsek.detailpolsekpenjualan', compact('masyarakat'));
    }
}
