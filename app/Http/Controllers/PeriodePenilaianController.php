<?php

namespace App\Http\Controllers;

use App\Models\MasterTahunPeriode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Svg\Tag\Rect;

class PeriodePenilaianController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');

        $periods = MasterTahunPeriode::when($search, function ($query, $search) {
            // Get all columns from the 'master_tahun_periode' table
            $columns = Schema::getColumnListing('master_tahun_periode');

            $query->where(function($query) use ($search, $columns) {
                foreach ($columns as $column) {
                    // $query->orWhere($column, 'like', '%' . $search . '%');
                    if (in_array($column, ['start_date', 'end_date'])) {
                        // Format the date column and search within it
                        $query->orWhere(DB::raw("DATE_FORMAT($column, '%d %M %Y')"), 'like', '%' . $search . '%');
                    } else {
                        // Regular search for other columns
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                }
            });

            return $query;
        })->paginate(10);

        //Get Active Periode
        $HelperController = new HelperController();
        $active_periode = $HelperController->get_active_periode();
        $string_periode_active = '';

        if($active_periode == null) {
            $string_periode_active = 'Tidak ada periode aktif saat ini';
        } else {
            $tahun = $active_periode->tahun;
            $periode = $active_periode->periode;
            $start_date = Carbon::parse($active_periode->start_date)->translatedFormat('j F Y');
            $end_date = Carbon::parse($active_periode->end_date)->translatedFormat('j F Y');
            $string_periode_active = 'Tahun '.$tahun.', Periode '.$periode.' : '.$start_date.' - '.$end_date;
        }


        return view('periode-penilaian.index', compact('periods', 'string_periode_active'));
    }

    public function create() {
        return view('periode-penilaian.create');
    }

    public function store(Request $request) {
        // Validate the incoming request data
        $request->validate([
            'tahun' => 'required',
            'periode' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'limit_date' => 'required'
        ]);

        MasterTahunPeriode::create([
            'tahun' => $request->input('tahun'),
            'periode' => $request->input('periode'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'limit_date' => $request->input('limit_date'),
            'is_active' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('penilaian-menu-periode')->with('success', 'User added successfully!');
    }

    public function edit($id) {
        $period = MasterTahunPeriode::where('id', $id)->first();
        $isActive = $period->is_active;
        return view('periode-penilaian.edit', compact('period', 'isActive'));
    }

    public function update(Request $request, $id) {
        $period = MasterTahunPeriode::where('id', $id)->first();

        $request->validate([
            'tahun' => 'required',
            'periode' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'limit_date' => 'required'
        ]);

        $period->update([
            'tahun' => $request->input('tahun'),
            'periode' => $request->input('periode'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'limit_date' => $request->input('limit_date'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Cache::flush();

        return redirect()->route('penilaian-menu-periode')->with('success', 'User edited successfully!');
    }

    public function delete($id) {
        $periode = MasterTahunPeriode::where('id', $id)->first();
        $periode->delete();

        Cache::flush();

        return redirect()->route('penilaian-menu-periode')->with('success', 'User deleted successfully!');
    }

    public function toggle($id) {

        $periode = MasterTahunPeriode::where('id', $id)->first();

        if($periode->is_active == 1) {
            $periode->update([
                'is_active' => 0,
                'updated_at' => Carbon::now()
            ]);
        } else {
            //Check is_active == 1 and there's an active period running
            $HelperController = new HelperController();
            $active_periode = $HelperController->get_active_periode();

            if($active_periode != null) {
                //Turn off the active periode first
                $off_periode = MasterTahunPeriode::where('id', $active_periode->id)->first();
                $off_periode->update([
                    'is_active' => 0,
                    'updated_at' => Carbon::now()
                ]);
            }

            $periode->update([
                'is_active' => 1,
                'updated_at' => Carbon::now()
            ]);


        }

        Cache::flush();

        return redirect()->route('penilaian-menu-periode')->with('success', 'User deleted successfully!');
    }
}
