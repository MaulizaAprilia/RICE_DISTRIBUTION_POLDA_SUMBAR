<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masyarakat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasyarakatController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar, filter berdasarkan user
        $query = Masyarakat::query()
            ->select('id', 'jumlah_beras', 'created_at', 'foto_ktp')
            ->where('created_by', Auth::id());

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

        // Filter tanggal manual jika ada
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Hitung total beras sesuai filter
        $totalBeras = $query->sum('jumlah_beras');

        // Ambil data untuk tabel dengan pagination
        $masyarakat = $query->latest()->paginate(10)->withQueryString();

        return view('user.masyarakat.page', compact('masyarakat', 'totalBeras'));
    }

    public function showPage()
    {
        return view('user.masyarakat.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah_beras' => 'required|integer|min:1',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'jumlah_beras.required' => 'Jumlah beras wajib diisi.',
            'jumlah_beras.integer' => 'Jumlah beras harus berupa angka bulat.',
            'jumlah_beras.min' => 'Jumlah beras minimal 1.',
            'foto_ktp.image' => 'Foto KTP harus berupa file gambar.',
            'foto_ktp.mimes' => 'Format foto KTP harus jpeg, png, jpg, atau gif.',
            'foto_ktp.max' => 'Ukuran Foto KTP maksimal 10 MB.',
        ]);

        try {
            DB::beginTransaction();

            $fotoPath = null;
            $uploadedFiles = [];

            if ($request->hasFile('foto_ktp')) {
                $file = $request->file('foto_ktp');
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());
                $destinationPath = public_path('uploads/ktp');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $filename);
                $uploadedFiles[] = $destinationPath . '/' . $filename;
                $fotoPath = $filename;
            }

            Masyarakat::create([
                'polres_id' => Auth::user()->profile->polres_id,
                'polsek_id' => Auth::user()->profile->polsek_id,
                'created_by' => Auth::id(),
                'jumlah_beras' => $request->jumlah_beras,
                'foto_ktp' => $fotoPath,
            ]);

            DB::commit();
            return redirect('/user/masyarakat')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data Masyarakat Berhasil Di Tambah!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal tambah data', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            foreach ($uploadedFiles as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat menambah data. Silakan coba lagi.'
            ]);
        }
    }

    public function detailPage($id)
    {
        $masyarakat = Masyarakat::where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();
        return view('user.masyarakat.detail', compact('masyarakat'));
    }

    public function destroy($id)
    {
        try {
            $masyarakat = Masyarakat::where('id', $id)
                ->where('created_by', Auth::id())
                ->firstOrFail();

            if ($masyarakat->foto_ktp) {
                $filePath = public_path('uploads/ktp/' . $masyarakat->foto_ktp);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $masyarakat->delete();

            return redirect()->route('user.masyarakat')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data masyarakat berhasil dihapus.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('user.masyarakat')->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Data tidak ditemukan atau Anda tidak berhak menghapus data ini.',
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('user.masyarakat')->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.',
            ]);
        }
    }

    public function showEdit($id)
    {
        $masyarakat = Masyarakat::where('id', $id)
            ->where('created_by', Auth::id())
            ->firstOrFail();
        return view('user.masyarakat.edit', compact('masyarakat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_beras' => 'required|integer|min:1',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'jumlah_beras.required' => 'Jumlah beras wajib diisi.',
            'jumlah_beras.integer' => 'Jumlah beras harus berupa angka bulat.',
            'jumlah_beras.min' => 'Jumlah beras minimal 1.',
            'foto_ktp.image' => 'Foto KTP harus berupa file gambar.',
            'foto_ktp.mimes' => 'Format foto KTP harus jpeg, png, jpg, atau gif.',
            'foto_ktp.max' => 'Ukuran Foto KTP maksimal 10 MB.',
        ]);

        try {
            DB::beginTransaction();

            $masyarakat = Masyarakat::findOrFail($id);
            $masyarakat->jumlah_beras = $request->jumlah_beras;

            $uploadedFiles = [];

            if ($request->hasFile('foto_ktp')) {
                $file = $request->file('foto_ktp');
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());
                $destinationPath = public_path('uploads/ktp');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $oldFile = public_path('uploads/ktp/' . $masyarakat->foto_ktp);
                if ($masyarakat->foto_ktp && file_exists($oldFile)) {
                    unlink($oldFile);
                }

                $file->move($destinationPath, $filename);
                $uploadedFiles[] = $destinationPath . '/' . $filename;

                $masyarakat->foto_ktp = $filename;
            }

            $masyarakat->save();

            DB::commit();

            return redirect()->route('user.masyarakat')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data Masyarakat berhasil diperbarui!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal update profil', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            foreach ($uploadedFiles as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat update data. Silakan coba lagi.'
            ]);
        }
    }
}