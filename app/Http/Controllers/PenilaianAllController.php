<?php

namespace App\Http\Controllers;

use App\Models\HeaderPA;
use App\Models\MasterTahunPeriode;
use App\Models\StatusPenilaian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class PenilaianAllController extends Controller
{
    public function index(Request $request)
    {
        $HelperController = new HelperController();

        // Get the search input
        $search = $request->input('search');
        $selected_periode = $request->input('periode');
        $selected_company = $request->input('company');
        $selected_status = $request->input('status');
        $selected_status_id = $request->input('status_id');
        $selected_score = $request->input('selected_score');


        //Get active master_tahun_periode
        $active_periode = $HelperController->get_active_periode();
        $is_in_periode = false;
        // Check if today's date is between start_date and end_date
        if (Carbon::today()->between($active_periode->start_date, $active_periode->end_date)) {
            $is_in_periode = true;
        }

        //For 'Semua' or null filters
        if($selected_periode == '00' || $selected_periode == 'Semua' || $selected_periode == null) {
            $selected_periode = $active_periode->id;
        }

        if($selected_company == '00' || $selected_company == 'Semua') {
            $selected_company = null;
        }

        if($selected_status_id == '00' || $selected_status_id == 'Semua') {
            $selected_status_id = null;
        }

        if($selected_score == '00' || $selected_score == 'Semua') {
            $selected_score = null;
        }

        //Renew $header_pa variable
        $header_pa = HeaderPA::where('id_master_tahun_periode', $selected_periode)
            ->when($search, function ($query, $search) {
                // Get all columns from the 'header_pa' table
                $columns = Schema::getColumnListing('header_pa');

                $query->where(function ($query) use ($search, $columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });

                return $query;
            })
            ->when($selected_company, function ($query, $selected_company) {
                return $query->where('perusahaan', $selected_company);
            })
            ->when($selected_status_id, function ($query, $selected_status_id) {
                return $query->where('id_status_penilaian', $selected_status_id);
            })
            ->when($selected_score, function ($query, $selected_score) {
                return $query->where(function ($query) use ($selected_score) {
                    // Check the fields in priority order and match the first non-null value to $selected_score
                    $query->where('nilai_akhir', $selected_score)
                          ->orWhere(function ($query) use ($selected_score) {
                              $query->whereNull('nilai_akhir')->where('revisi_gm', $selected_score);
                          })
                          ->orWhere(function ($query) use ($selected_score) {
                              $query->whereNull('nilai_akhir')
                                    ->whereNull('revisi_gm')
                                    ->where('revisi_hod', $selected_score);
                          })
                          ->orWhere(function ($query) use ($selected_score) {
                              $query->whereNull('nilai_akhir')
                                    ->whereNull('revisi_gm')
                                    ->whereNull('revisi_hod')
                                    ->where('nilai_awal', $selected_score);
                          });
                });
            })
            ->orderBy('nama_employee', 'asc')->paginate(20);

        //Filter Data
        $all_periode = MasterTahunPeriode::all();
        $all_status = StatusPenilaian::all();
        $HelperController = new HelperController();
        $all_companies = $HelperController->get_all_companies();

        $scores = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'];

        return view('penilaian-all.index', compact(['header_pa', 'is_in_periode', 'all_periode', 'active_periode', 'all_status', 'all_companies', 'scores']));
    }

    public function penilaian_all_detail() {


        return view('penilaian-all.detail');
    }
}
