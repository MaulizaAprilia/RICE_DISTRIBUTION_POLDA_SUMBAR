<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Polsek;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index()
    {   
        return view('register',);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();

            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
            ]);

            Log::info('User berhasil dibuat', [
                'user_id' => $user->id,
                'created_at' => $user->created_at,
            ]);

            $foto_ktp = null;
            $foto_wajah = null;

            if ($request->hasFile('foto_ktp')) {
                $file = $request->file('foto_ktp');
                Log::info('File foto_ktp ditemukan', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType(),
                    'size_kb' => $file->getSize() / 1024
                ]);

                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());
                $destinationPath = public_path('uploads/ktp');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                Log::info("File baru disimpan: {$filename}");
                $uploadedFiles[] = $destinationPath . '/' . $filename;

                $foto_ktp = $filename;
            } else {
                Log::warning('Tidak ada file foto_ktp dikirim di request');
            }

            if ($request->hasFile('foto_wajah')) {
                $file = $request->file('foto_wajah');
                Log::info('File foto_wajah ditemukan', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType(),
                    'size_kb' => $file->getSize() / 1024
                ]);

                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());
                $destinationPath = public_path('uploads/wajah');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                Log::info("File baru disimpan: {$filename}");
                $uploadedFiles[] = $destinationPath . '/' . $filename;

                $foto_wajah = $filename;
            } else {
                Log::warning('Tidak ada file foto_wajah dikirim di request');
            }

            $polres_id = null;
            $polsek_id = null;

            list($type, $id) = explode('|', $request->polsek_id);
            if ($type === 'polres') {
                $polres_id = $id;
                $polsek_id = null;
            } else {
                $polsek = Polsek::findOrFail($id);
                $polres_id = $polsek->polres_id;
                $polsek_id = $id;
            }


            UserProfile::create([
                'user_id' => $user->id,
                'polsek_id' => $polsek_id,
                'nrp' => $validated['nrp'],
                'pangkat' => $validated['pangkat'],
                'jabatan' => $validated['jabatan'],
                'foto_ktp' => $foto_ktp,
                'foto_wajah' => $foto_wajah,
                'polres_id' => $polres_id
            ]);

            Log::info('User Profile berhasil dibuat');

            DB::commit();

            return redirect('/')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Registrasi berhasil!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error updating profile: ' . $th->getMessage());
            foreach ($uploadedFiles as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi Kesalahan Saat Register!'
            ]);
        }
    }

}
