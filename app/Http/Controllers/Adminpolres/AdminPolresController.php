<?php

namespace App\Http\Controllers\Adminpolres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPolresController extends Controller
{
    public function index()
    {
        return view('adminpolres.dashboard');
    }
}
