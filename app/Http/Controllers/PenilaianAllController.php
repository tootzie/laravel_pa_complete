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

        //Get all subordinates based on logged in user ektp
        // $ektpUser = $request->input('ektp');

        //Get active master_tahun_periode
        $active_periode = $HelperController->get_active_periode();

        $is_in_periode = false;

        // Check if today's date is between start_date and end_date
        if (Carbon::today()->between($active_periode->start_date, $active_periode->end_date)) {
            $is_in_periode = true;
        }

        //Renew $header_pa variable
        $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)
            ->where('id_status_penilaian', '!=', '100')
            ->when($search, function ($query, $search) {
                // Get all columns from the 'header_pa' table
                $columns = Schema::getColumnListing('header_pa');

                $query->where(function ($query) use ($search, $columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });

                return $query;
            })->orderBy('nama_employee', 'asc')->paginate(20);

        //Filter Data
        $all_periode = MasterTahunPeriode::all();
        $all_status = StatusPenilaian::all();
        $HelperController = new HelperController();
        $all_companies = $HelperController->get_all_companies();

        return view('penilaian-all.index', compact(['header_pa', 'is_in_periode', 'all_periode', 'active_periode', 'all_status', 'all_companies']));
    }

    public function penilaian_all_detail() {


        return view('penilaian-all.detail');
    }
}
