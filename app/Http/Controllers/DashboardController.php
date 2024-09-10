<?php

namespace App\Http\Controllers;

use App\Models\HeaderPA;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //Get data for chart and table
        $data = $this->get_chart_data();

        //Category PA (for dropdown)
        $kategori_pa = collect($data)->pluck('kategori_pa')->unique();

        return view('dashboard.index', compact(['data', 'kategori_pa']));
    }

    public function get_chart_data($category = null) {
        $HelperController = new HelperController();

        //Get all subordinates based on logged in user ektp
        $data_subordinates = $HelperController->get_subordinates();
        $ektp_subordinates = array_column($data_subordinates, 'ektp');

        //Get active master_tahun_periode
        $active_periode = $HelperController->get_active_periode();

        //Select all employees in $ektp_subordinates from  where id_master_tahun_periode is $active_periode
        if($category != null) {
            $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)
            ->whereIn('ektp_employee', $ektp_subordinates)
            ->where('kategori_pa', $category) // Filter by category
            ->get();
        } else {
            $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)->whereIn('ektp_employee', $ektp_subordinates)->get();
        }

        // Define the score levels
        $scores = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'];

        // Group data by 'kategori_pa'
        $data = $header_pa->groupBy('kategori_pa')->map(function ($groupedData, $kategori_pa) use ($scores) {
            // Initialize counts for each score
            $jumlah = collect($scores)->map(function ($nilai) use ($groupedData) {
                return [
                    'nilai' => $nilai,
                    'nilai_awal_count' => $groupedData->where('nilai_awal', $nilai)->count(),
                    'revisi_hod_count' => $groupedData->where('revisi_hod', $nilai)->count(),
                ];
            });

            return [
                'kategori_pa' => $kategori_pa,
                'jumlah' => $jumlah
            ];
        });

        return $data;
    }

    public function summary()
    {
        return view('dashboard.summary');
    }
}
