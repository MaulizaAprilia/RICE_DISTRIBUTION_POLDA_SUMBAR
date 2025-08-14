<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Polres;
use App\Models\Polsek;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AkunPolsekController extends Controller
{
    public function index(){
        $akun = User::select('id','name','password')->where('role', 'admin polsek')->paginate(10)->withQueryString();
        return view('superadmin.akunpolsek.page',compact('akun'));
    }

    public function tambahPage(){
        $polres = Polres::select('id','nama')->get();
        return view('superadmin.akunpolsek.tambah',compact('polres'));
    }
    
    public function store(Request $request){
        $request->validate([
            'polsek_id' => 'required|exists:polsek,id',   
            'name' => ['required', 'string', 'max:255','unique:users,name'], 
        ], [
            'polsek_id.required' => 'Polsek wajib dipilih.',
            'polsek_id.exists' => 'polsek tidak valid.',

            'name.required' => 'Username wajib diisi.',
            'name.string' => 'Username harus berupa teks.',
            'name.max' => 'Username maksimal :max karakter.',
            'name.unique' => 'Username sudah terdaftar',
        ]);
        try {
            $cekAkun = UserProfile::where('polsek_id', $request->polsek_id)
            ->whereHas('user', function ($query) {
                $query->where('role', 'admin polsek');
            })
            ->first();
        
            if ($cekAkun) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'text' => 'Akun untuk Polsek tersebut sudah ada!'
                ]);
            }

            // Mulai transaksi database
            DB::beginTransaction();

            // Simpan user ke database
            $user = User::create([
                'name' => $request->name,
                'password' => Hash::make($request->name),
                'role' => 'admin polsek',
            ]);

            $polsek = Polsek::findOrFail($request->polsek_id);
            // simpan user profile
            $userprofile = UserProfile::create([
                'user_id' => $user->id,
                'polres_id' => $polsek->polres_id,
                'polsek_id' => $request->polsek_id,
            ]);

            // Commit transaksi
            DB::commit();

            return redirect()->route('superadmin.akun.polsek')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Akun Polsek Berhasil Di tambah!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat tambah data. Silakan coba lagi.'
            ]);
        }

    }

    public function editPage($id){
        $profile = UserProfile::where('user_id', $id)->firstOrFail();
        $user = User::where('id', $id)->firstOrFail();
        return view('superadmin.akunpolsek.edit',compact('profile','user'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'polsek_id' => 'required|exists:polsek,id',   
            'name' => ['required', 'string', 'max:255'], 
            'password' => ['nullable', 'string', 'min:8'],
        ], [
            'polsek_id.required' => 'Polres/ta wajib dipilih.',
            'polsek_id.exists' => 'polsek tidak valid.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi minimal :min karakter.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal :max karakter.',
        ]);

        try {
            if ($request->polsek_id != $request->id_polsek) {
                $cekAkun = UserProfile::where('polsek_id', $request->polsek_id)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'admin polsek');
                })
                ->first();
            
                if ($cekAkun) {
                    return redirect()->back()->with('alert', [
                        'type' => 'error',
                        'title' => 'Gagal',
                        'text' => 'Akun untuk Polsek tersebut sudah ada!'
                    ]);
                }
            }

            DB::beginTransaction();

            $profile = UserProfile::where('user_id', $id)->firstOrFail();
            $profile->polsek_id = $request->polsek_id;
            $profile->save();

            $user = User::findOrFail($id);
            $user->name = $request->name;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            DB::commit();
            return redirect()->route('superadmin.akun.polsek')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Akun Polsek Berhasil Di Perbarui!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.'
            ]);
        }

        
    }

    public function destroy($id){
        try {
            DB::beginTransaction();

        
            // Perbaikan findOrFail
            $profile = UserProfile::where('user_id', $id)->firstOrFail();
            $profile->delete();

            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();

            return redirect()->route('superadmin.akun.polsek')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Akun Polsek berhasil dihapus.',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('superadmin.akun.polsek')->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat menghapus akun. Silahkan coba lagi.',
            ]);
        }
    }

}
