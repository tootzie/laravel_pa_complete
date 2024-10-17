<?php

namespace App\Http\Controllers;

use App\Exports\LaporanNilaiAkhirExport;
use App\Models\HeaderPA;
use App\Models\MasterTahunPeriode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DownloadLaporanController extends Controller
{
    public function index_laporan_nilai_akhir()
    {
        $periods = MasterTahunPeriode::all();
        return view('exports.index_laporan_nilai_akhir', compact(['periods']));
    }

    public function laporan_nilai_akhir(Request $request)
    {
        $request->validate([
            'id_master_tahun_periode' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value == '00') {
                        $fail('Please select a period.');
                    }
                },
            ],
        ]);
        $id_master_tahun_periode = $request->input('id_master_tahun_periode');
        $master_tahun_periode = MasterTahunPeriode::where('id', $id_master_tahun_periode)->first();
        $filename = 'laporan_nilai_akhir_tahun' . $master_tahun_periode->tahun . '_periode' . $master_tahun_periode->periode . '.xlsx';

        return Excel::download(new LaporanNilaiAkhirExport($id_master_tahun_periode), $filename);
    }
}
