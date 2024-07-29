<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        return view('penilaian.index');
    }

    public function penilaian_detail()
    {
        return view('penilaian.penilaian-detail');
    }

    public function penilaian_detail_awal()
    {
        return view('penilaian.penilaian-detail-awal');
    }
}
