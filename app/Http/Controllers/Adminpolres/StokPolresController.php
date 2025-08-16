<?php

namespace App\Http\Controllers\Adminpolres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stok;
use Illuminate\Support\Facades\Auth;

class StokPolresController extends Controller
{
    /**
     * Tampilkan daftar stok beras untuk polres yang login
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil polres_id dari relasi profile
        $polresId = $user->profile->polres_id ?? null;

        if (!$polresId) {
            abort(403, 'User tidak memiliki polres_id');
        }

        $data = Stok::where('polres_id', $polresId)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalStokAwal = $data->sum('stok_awal');

        return view('adminpolres.stokpolres', compact('data', 'totalStokAwal'));
    }

    /**
     * Simpan stok baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'sumber_beras' => 'required|string|max:255',
            'stok_awal' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $polresId = $user->profile->polres_id ?? null;

        if (!$polresId) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'User tidak memiliki polres_id, stok tidak dapat disimpan.',
            ]);
        }

        Stok::create([
            'polres_id'        => $polresId,
            'polsek_id'        => null,
            'sumber_beras'     => $request->sumber_beras,
            'stok_awal'        => $request->stok_awal,
            'distribusi_beras' => 0,
            'stok_sisa'        => $request->stok_awal,
            'created_at'       => now(),
        ]);

        return redirect()->route('admin.polres.stokpolres')
            ->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data stok beras berhasil ditambahkan.',
            ]);
    }
}
