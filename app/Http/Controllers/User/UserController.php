<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $profileIncomplete = false;

        if (!$user->profile || empty($user->profile->nrp) || empty($user->profile->pangkat) || empty($user->profile->jabatan) || empty($user->profile->foto_ktp) ) {
            $profileIncomplete = true;
        }
        return view('user.dashboard',compact('user', 'profileIncomplete'));
    }
}
