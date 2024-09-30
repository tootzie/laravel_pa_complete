<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenilaianByUserController extends Controller
{
    public function index()
    {
        return view('penilaian-by-user.index');
    }
}
