<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenilaianAllController extends Controller
{
    public function index()
    {
        return view('penilaian-all.index');
    }

    public function penilaian_all_detail() {
        return view('penilaian-all.detail');
    }
}
