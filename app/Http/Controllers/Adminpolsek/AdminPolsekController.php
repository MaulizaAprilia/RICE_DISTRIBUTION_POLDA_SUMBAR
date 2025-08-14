<?php

namespace App\Http\Controllers\Adminpolsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPolsekController extends Controller
{
    public function index()
    {
        return view('adminpolsek.dashboard');
    }
}
