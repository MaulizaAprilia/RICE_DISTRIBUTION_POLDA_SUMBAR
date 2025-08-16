<?php

namespace App\Http\Controllers\Adminpolres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserPolsekController extends Controller
{
    public function index(Request $request)
    {
        $userLogin = Auth::user();
        $polresId = $userLogin->profile->polres_id ?? null; // pastikan user punya profile

        // Query user dengan role 'admin polsek' dan profile polres_id sama dengan user login
        $query = User::with('profile.polsek')
            ->where('role', 'admin polsek') // hanya admin polsek
            ->whereHas('profile', function($q) use ($polresId) {
                $q->where('polres_id', $polresId);
            });

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('profile.polsek', function($q2) use ($search) {
                      $q2->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $users = $query->paginate(10);

        return view('adminpolres.userpolsek', compact('users'));
    }
}
