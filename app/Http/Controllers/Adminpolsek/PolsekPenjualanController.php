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
        $user = Auth::user(); // Ambil user yang login
        $userPolresId = $user->polres_id;
        $userPolsekId = $user->polsek_id;

        // Query dasar, ambil semua data masyarakat + relasi user
        $query = Masyarakat::with('user:id,name')
            ->select('id', 'created_by', 'jumlah_beras', 'foto_ktp', 'created_at', 'polres_id', 'polsek_id')
            ->where('polres_id', $userPolresId)
            ->where('polsek_id', $userPolsekId)
            ->orderBy('created_at', 'desc');

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
        $user = Auth::user();
        $userPolresId = $user->polres_id;
        $userPolsekId = $user->polsek_id;

        $masyarakat = Masyarakat::with('user:id,name')
            ->where('polres_id', $userPolresId)
            ->where('polsek_id', $userPolsekId)
            ->findOrFail($id);

        return view('adminpolsek.detailpolsekpenjualan', compact('masyarakat'));
    }
}