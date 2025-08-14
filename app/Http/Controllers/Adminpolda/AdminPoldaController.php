<?php

namespace App\Http\Controllers\Adminpolda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPoldaController extends Controller
{
    public function index()
    {
        return view('adminpolda.dashboard');
    }
}
