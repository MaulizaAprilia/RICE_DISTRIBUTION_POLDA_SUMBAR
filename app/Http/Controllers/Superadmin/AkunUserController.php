<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AkunUserController extends Controller
{
    public function index()
    {
        $query = User::where('role', 'user');

        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('profile', function($q2) use ($search) {
                      $q2->where('nrp', 'like', '%' . $search . '%');
                  });
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

       
        return view('superadmin.akunuser.page', compact('users'));
    }

    
    public function detailUser($id){
        $users = User::where('role', 'user')->where('id' , $id)->first();
        return view('superadmin.akunuser.detail',compact('users',));
    }

    public function setujuiUser($id){
        try {
            $users = User::where('id', $id)->firstOrFail();

            if($users->is_approved == 0){
                $users->is_approved = 1;
            }else{
                $users->is_approved = 0;
            }
            
            $users->save();

            return redirect()->route('superadmin.akun.user')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Akun Berhasil Disetujui'
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Terjadi kesalahan saat menyetujui akun. Silakan coba lagi.'
            ]);
        }
    }

    private function isProfileComplete($profile)
    {
        if (!$profile) {
            return false; // Jika profile tidak ada, berarti belum lengkap
        }

        $requiredFields = ['nrp', 'pangkat', 'jabatan', 'foto_ktp'];

        foreach ($requiredFields as $field) {
            if (empty($profile->$field)) {
                return false;
            }
        }

        return true;
    }

}
