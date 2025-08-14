<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        // Ambil profile user berdasarkan relasi
        $profile = $user->profile;
        return view('user.profile', compact('user', 'profile'));
    }

    public function update(Request $request, $id)

{
    $request->validate([
        'nrp' => 'required|digits:8|exists:user_profile,nrp',
        'pangkat' => 'required|string|max:255',
        'jabatan' => 'required|string|max:255',
        'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
    ], [
        'nrp.required' => 'NRP wajib diisi.',
        'nrp.digits' => 'NRP harus terdiri dari tepat 8 digit angka.',
        'nrp.exists' => 'NRP tidak ditemukan.',
        
        'pangkat.required' => 'Pangkat wajib diisi.',
        'pangkat.string' => 'Pangkat harus berupa teks.',
        'pangkat.max' => 'Pangkat maksimal 255 karakter.',
    
        'jabatan.required' => 'Jabatan wajib diisi.',
        'jabatan.string' => 'Jabatan harus berupa teks.',
        'jabatan.max' => 'Jabatan maksimal 255 karakter.',
    
        'foto_ktp.image' => 'Foto KTP harus berupa file gambar.',
        'foto_ktp.mimes' => 'Format foto KTP harus jpeg, png, jpg, atau gif.',
        'foto_ktp.max' => 'Ukuran Foto KTP maksimal 10 MB.',
    ]);

    try {
        
        
        DB::beginTransaction();

        
        $profile = UserProfile::findOrFail($id);

        // 3. Update field teks
        $profile->nrp = $request->nrp;
        $profile->pangkat = $request->pangkat;
        $profile->jabatan = $request->jabatan;

        // 4. Cek file
        if ($request->hasFile('foto_ktp')) {
            $file = $request->file('foto_ktp');
            \Log::info('File foto_ktp ditemukan', [
                'original_name' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'size_kb' => $file->getSize() / 1024
            ]);

            // Nama file aman
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());

            // Pastikan folder ada
            $destinationPath = public_path('uploads/ktp');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
                \Log::info("Folder uploads/ktp dibuat");
            }

            // Hapus file lama kalau ada
            $oldFile = public_path('uploads/ktp/' . $profile->foto_ktp);
            if ($profile->foto_ktp && file_exists($oldFile)) {
                unlink($oldFile);
                \Log::info("File lama dihapus: {$oldFile}");
            }

            // Simpan file baru
            $file->move($destinationPath, $filename);
            \Log::info("File baru disimpan: {$filename}");

            $profile->foto_ktp = $filename;
        } else {
            \Log::warning('Tidak ada file foto_ktp dikirim di request');
        }

        // 5. Simpan perubahan
        $profile->save();
        \Log::info("Profile berhasil disimpan, foto_ktp: {$profile->foto_ktp}");

        DB::commit();

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Profil berhasil diperbarui!'
        ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal update profil', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.'
            ]);
        }
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // password_confirmation harus ada juga
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Password berhasil diubah.',
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat mengubah password. Silakan coba lagi.'
            ]);
        }
    }



}
