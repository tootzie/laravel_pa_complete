<?php
namespace App\Exports;

use App\Models\HeaderPA;
use App\Models\MasterTahunPeriode;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanNilaiAkhirExport implements FromView
{
    protected $id_master_tahun_periode;

    public function __construct($id_master_tahun_periode)
    {
        $this->id_master_tahun_periode = $id_master_tahun_periode;
    }

    public function view(): View
    {
        $masterTahunPeriode = MasterTahunPeriode::find($this->id_master_tahun_periode);
        $headerPAs = HeaderPA::where('id_master_tahun_periode', $this->id_master_tahun_periode)
        ->orderBy('nama_atasan', 'asc')
        ->get();

        return view('exports.laporan_nilai_akhir', [
            'headerPAs' => $headerPAs,
            'masterTahunPeriode' => $masterTahunPeriode
        ]);
    }
}
