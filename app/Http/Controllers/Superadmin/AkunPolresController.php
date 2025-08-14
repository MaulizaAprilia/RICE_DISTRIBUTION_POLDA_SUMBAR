<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Polres;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class AkunPolresController extends Controller
{
    public function index(){
        $akun = User::select('id','name','password')->where('role', 'admin polres')->paginate(10)->withQueryString();
        return view('superadmin.akunpolres.page',compact('akun'));
    }

    public function tambahPage(){
        $polres = Polres::select('id','nama')->get();
        return view('superadmin.akunpolres.tambah',compact('polres'));
    }

    public function store(Request $request){
        $request->validate([
            'polres_id' => 'required',   
            'name' => ['required', 'string', 'max:255','unique:users,name'], 
        ], [
            'polres_id.required' => 'Polres/ta wajib dipilih.',

            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal :max karakter.',
            'name.unique' => 'Username sudah terdaftar',
        ]);

        try {
            $cekAkun = UserProfile::where('polres_id', $request->polres_id)
            ->whereHas('user', function ($query) {
                $query->where('role', 'admin polres');
            })
            ->first();
        
            if ($cekAkun) {
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'text' => 'Akun untuk Polres/Ta tersebut sudah ada!'
                ]);
            }
            
            // Mulai transaksi database
            DB::beginTransaction();

            // Simpan user ke database
            $user = User::create([
                'name' => $request->name,
                'password' => Hash::make($request->name),
                'role' => 'admin polres',
            ]);

            // simpan user profile
            $userprofile = UserProfile::create([
                'user_id' => $user->id,
                'polres_id' => $request->polres_id,
            ]);

            // Commit transaksi
            DB::commit();
    
            return redirect()->route('superadmin.akun.polres')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data Polres/ta Berhasil Di Tambah!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat menambah data. Silakan coba lagi.'
            ]);
        }

    }

    public function editPage($id){
        // Ambil user profile berdasarkan user id
        $user1 = UserProfile::select('polres_id')->where('user_id',$id)->first();
        $user2 = User::select('id','name')->where('id',$id)->first();

        // Ambil data polres sesuai polres_id di user profile
        $polres = Polres::select('id', 'nama')->get();

        return view('superadmin.akunpolres.edit',compact('polres','user1','user2'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'polres_id' => 'required',   
        'name' => ['required', 'string', 'max:255'], 
        'password' => ['nullable', 'string', 'min:8'],
    ], [
        'polres_id.required' => 'Polres/ta wajib dipilih.',
        'password.string' => 'Kata sandi harus berupa teks.',
        'password.min' => 'Kata sandi minimal :min karakter.',
        'name.required' => 'Nama wajib diisi.',
        'name.string' => 'Nama harus berupa teks.',
        'name.max' => 'Nama maksimal :max karakter.',
    ]);

    try {
        if ($request->polres_id != $request->id_polres) {
            $cekAkun = UserProfile::where('polres_id', $request->polres_id)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'admin polres');
                })
                ->first();
        
            if ($cekAkun) {
                Log::warning('Gagal update - Akun untuk Polres/Ta sudah ada', [
                    'polres_id' => $request->polres_id
                ]);
                return redirect()->back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'text' => 'Akun untuk Polres/Ta tersebut sudah ada!'
                ]);
            }
        }

        DB::beginTransaction();

        
        
        $profile = UserProfile::where('user_id', $id)->firstOrFail();
        $profile->polres_id = $request->polres_id;
        $profile->save();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        DB::commit();

        return redirect()->route('superadmin.akun.polres')->with('alert', [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Data Polres/ta Berhasil Di Perbarui!'
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

            return redirect()->route('superadmin.akun.polres')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Akun Polres berhasil dihapus.',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('superadmin.akun.polres')->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat menghapus akun. Silahkan coba lagi.',
            ]);
        }
    }
}
