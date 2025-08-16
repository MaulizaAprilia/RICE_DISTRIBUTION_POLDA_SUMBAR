<?php

namespace App\Http\Controllers\AdminPolsek;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PolsekUserController extends Controller
{
    /**
     * Menampilkan daftar user di polsek admin yang login
     */
    public function index(Request $request)
    {
        $admin = Auth::user();
        $polsek_id = optional($admin->profile)->polsek_id;

        if (!$polsek_id) {
            return redirect()->back()->with('error', 'Admin tidak memiliki data polsek.');
        }

        $users = User::whereHas('profile', function ($q) use ($polsek_id) {
                $q->where('polsek_id', $polsek_id);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhereHas('profile', function ($subProfile) use ($search) {
                            $subProfile->where('nrp', 'like', "%{$search}%")
                                    ->orWhere('jabatan', 'like', "%{$search}%")
                                    ->orWhere('pangkat', 'like', "%{$search}%");
                        });
                });
            })
            ->with(['profile' => function ($q) {
                $q->select('id', 'user_id', 'polres_id', 'polsek_id', 'nrp', 'jabatan', 'pangkat')
                ->with(['polres:id,nama', 'polsek:id,nama']);
            }])
            ->paginate(10);

        return view('adminpolsek.akun-user', compact('users'));
    }

    /**
     * Menampilkan detail user di polsek admin yang login
     */
    public function detail($id)
    {
        $admin = Auth::user();
        $polsek_id = optional($admin->profile)->polsek_id;

        if (!$polsek_id) {
            return redirect()->back()->with('error', 'Admin tidak memiliki data polsek.');
        }

        $user = User::whereHas('profile', function ($q) use ($polsek_id) {
                $q->where('polsek_id', $polsek_id);
            })
            ->with(['profile' => function ($q) {
                $q->select('id', 'user_id', 'polres_id', 'polsek_id', 'nrp', 'pangkat', 'jabatan', 'foto_ktp', 'foto_wajah')
                  ->with(['polres:id,nama', 'polsek:id,nama']);
            }])
            ->findOrFail($id);

        return view('adminpolsek.detail-user', compact('user'));
    }
}
