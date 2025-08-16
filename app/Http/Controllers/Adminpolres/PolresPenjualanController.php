<?php

namespace App\Http\Controllers\AdminPolres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Polsek;
use App\Models\Masyarakat;

class PolresPenjualanController extends Controller
{
    /**
     * Tampilkan daftar distribusi beras per-polsek.
     */
    public function index(Request $request)
    {
        $admin = Auth::user();
        $polresId = optional($admin->profile)->polres_id;

        if (!$polresId) {
            return redirect()->back()->with('error', 'Admin tidak memiliki data polres.');
        }

        $query = Polsek::select(
            'polsek.id',
            'polsek.nama',
            'polsek.stok_beras',
            DB::raw('COALESCE(SUM(masyarakat.jumlah_beras), 0) as total_distribusi'),
            DB::raw('MAX(masyarakat.created_at) as last_distribusi')
        )
        ->leftJoin('masyarakat', 'masyarakat.polsek_id', '=', 'polsek.id')
        ->where('polsek.polres_id', $polresId)
        ->groupBy('polsek.id', 'polsek.nama', 'polsek.stok_beras');

        if ($request->filled('search') && $request->filled('field')) {
            $field = $request->field;
            $search = $request->search;

            if (in_array($field, ['nama', 'stok_beras'])) {
                $query->where("polsek.$field", 'like', "%{$search}%");
            } elseif ($field === 'total_distribusi') {
                $query->having('total_distribusi', 'like', "%{$search}%");
            }
        }

        if ($request->start_date && $request->end_date) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('masyarakat.created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ])->orWhereNull('masyarakat.id');
            });
        }

        $data = $query->get();

        $totalStokAwal   = $data->sum('stok_beras');
        $totalDistribusi = $data->sum('total_distribusi');

        return view('adminpolres.polrespenjualan', compact('data', 'totalStokAwal', 'totalDistribusi'));
    }

    /**
     * Tampilkan detail distribusi pada polsek tertentu.
     */
    public function detail(Request $request, $id)
    {
        $admin = Auth::user();
        $polresId = optional($admin->profile)->polres_id;

        if (!$polresId) {
            return redirect()->back()->with('error', 'Admin tidak memiliki data polres.');
        }

        $polsek = Polsek::where('id', $id)
            ->where('polres_id', $polresId)
            ->firstOrFail();

        // Query detail distribusi dengan relasi user.profile
        $detailQuery = Masyarakat::with('user.profile')
            ->where('polsek_id', $polsek->id);

        // Filter tanggal
        if ($request->start_date && $request->end_date) {
            $detailQuery->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter pencarian
        if ($request->filled('field') && $request->filled('search')) {
            $field = $request->field;
            $search = $request->search;

            if (in_array($field, ['name', 'nrp', 'jabatan', 'pangkat'])) {
                $detailQuery->whereHas('user.profile', function($q) use ($field, $search) {
                    $q->where($field, 'like', "%{$search}%");
                });
            } elseif ($field == 'jumlah_beras') {
                $detailQuery->where('jumlah_beras', $search);
            }
        }

        // Pagination 10 per halaman
        $detail = $detailQuery->orderBy('created_at', 'desc')->paginate(10);

        // Total beras distribusi polsek (hanya dari data yang sesuai filter)
        $totalDistribusi = $detailQuery->sum('jumlah_beras');

        // Ambil stok awal dari polsek
        $stokAwal = $polsek->stok_beras;

        // Hitung sisa stok
        $sisaStok = $stokAwal - $totalDistribusi;

        return view('adminpolres.detailpolrespenjualan', compact(
            'polsek',
            'detail',
            'totalDistribusi',
            'stokAwal',
            'sisaStok'
        ));
    }
}