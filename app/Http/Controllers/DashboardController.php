<?php

namespace App\Http\Controllers;

use App\Models\HeaderPA;
use App\Models\MasterTahunPeriode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        //Check if the user logged in has data in header PA, if not add new
        $HelperController = new HelperController();

        $ektpUser = auth()->user()->ektp;

        //Get active master_tahun_periode
        $active_periode = $HelperController->get_active_periode();

        //Get all subordinates based on logged in user ektp
        $data_subordinates = Cache::remember('data_subordinates_' . $ektpUser, 60 * 60, function () use ($HelperController, $ektpUser, $active_periode) {
            return $HelperController->get_subordinates($ektpUser, $active_periode->limit_date);
        });
        $ektp_subordinates = array_column($data_subordinates, 'ektp');

        $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)->whereIn('ektp_employee', $ektp_subordinates)->get();

        //If result is empty, add all employees name without any score to header_pa
        if ($header_pa->isEmpty()) {
            $id_master_tahun_periode = $active_periode->id;
            //Store each employee to header_pa without score
            foreach ($ektp_subordinates as $ektp_subordinate) {
                if ($ektp_subordinate != null) {
                    try {
                        HeaderPA::create([
                            'id_master_tahun_periode' => $id_master_tahun_periode,
                            'id_status_penilaian' => 100,
                            'ektp_employee' => $ektp_subordinate,
                            'nama_employee' => $data_subordinates[$ektp_subordinate]['name'],
                            'perusahaan' => $data_subordinates[$ektp_subordinate]['companyCode'],
                            'departemen' => $data_subordinates[$ektp_subordinate]['department'],
                            'kategori_pa' => $data_subordinates[$ektp_subordinate]['paCode'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'updated_by' => 'Sistem'
                        ]);
                    } catch (\Exception $e) {
                        // Output the exception message for debugging
                        dd($e->getMessage());
                    }
                }
            }
        } else {
            if ($header_pa->count() != count($data_subordinates)) {
                // Find which subordinates are missing from header_pa
                $existing_ektps = $header_pa->pluck('ektp_employee')->toArray();
                $missing_subordinates = array_filter($data_subordinates, function ($subordinate) use ($existing_ektps) {
                    return !in_array($subordinate['ektp'], $existing_ektps);
                });

                // Add the missing subordinates to header_pa
                $id_master_tahun_periode = $active_periode->id;
                foreach ($missing_subordinates as $subordinate) {
                    if ($subordinate['ektp'] != null) {
                        try {
                            HeaderPA::create([
                                'id_master_tahun_periode' => $id_master_tahun_periode,
                                'id_status_penilaian' => 100,
                                'ektp_employee' => $subordinate['ektp'],
                                'nama_employee' => $subordinate['name'],
                                'perusahaan' => $subordinate['companyCode'],
                                'departemen' => $subordinate['department'],
                                'kategori_pa' => $subordinate['paCode'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                                'updated_by' => 'Sistem'
                            ]);
                        } catch (\Exception $e) {
                            // Output the exception message for debugging
                            dd($e->getMessage());
                        }
                    }
                }
            }
        }

        //Get data for chart and table
        $data = $this->get_chart_data();

        //Category PA (for dropdown)
        $kategori_pa = collect($data)->pluck('kategori_pa')->unique();

        return view('dashboard.index', compact(['data', 'kategori_pa']));
    }

    public function get_chart_data($category = null)
    {
        $HelperController = new HelperController();

        $ektpUser = auth()->user()->ektp;

               //Get active master_tahun_periode
               $active_periode = $HelperController->get_active_periode();

        //Get all subordinates based on logged in user ektp
        $data_subordinates = Cache::remember('data_subordinates_' . $ektpUser, 60 * 60, function () use ($HelperController, $ektpUser, $active_periode) {
            return $HelperController->get_subordinates($ektpUser, $active_periode->limit_date);
        });
        $ektp_subordinates = array_column($data_subordinates, 'ektp');



        //Select all employees in $ektp_subordinates from  where id_master_tahun_periode is $active_periode
        if ($category != null) {
            $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)
                ->whereIn('ektp_employee', $ektp_subordinates)
                ->where('kategori_pa', $category) // Filter by category
                ->get();
        } else {
            // dd($active_periode->id);
            $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)->whereIn('ektp_employee', $ektp_subordinates)->get();
            // dd($header_pa);
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
                    'revisi_hod_count' => auth()->user()->userRole->id == 2 ? $groupedData->where('revisi_hod', $nilai)->count() :  $groupedData->where('revisi_gm', $nilai)->count(),
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
        $summaryData = $this->get_chart_data_summary();
        $chartData = $summaryData['data'];
        $years = array_reverse($summaryData['years']);

        return view('dashboard.summary', compact(['chartData', 'years']));
    }

    public function get_chart_data_summary($year = null) {
        $inputYear = '';
        if ($year != null) {
            $inputYear = $year;
        } else {
            $inputYear = Carbon::now()->format('Y');
        }


        $years = [$inputYear - 1, $inputYear];
        $scores = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'];

        $byTahun = [];
        $byCompany = [];

        $headerData = HeaderPA::with('MasterTahunPeriode')
        ->whereHas('MasterTahunPeriode', function($query) use ($years){
            $query->whereIn('tahun', $years);
        })
        ->get();


        //Group by year and count scores
        foreach ($years as $year) {
            $byTahun[$year] = [];
            foreach($scores as $score) {
                // Filter records for the selected year
                $filteredByYear = $headerData->filter(function ($record) use ($year) {
                    return $record->masterTahunPeriode->tahun == $year;
                });

                $byTahun[$year][$score] = $filteredByYear->where('nilai_akhir', $score)->count();
            }
        }

        //Group by company and count scores
        $companies = $headerData->groupBy('perusahaan');
        foreach ($companies as $company => $companyRecords) {
            // Filter records for the selected year
            $filteredByYear = $companyRecords->filter(function ($record) use ($inputYear) {
                return $record->masterTahunPeriode->tahun == $inputYear;
            });

            $byCompany[$company] = [];
            foreach ($scores as $score) {
                $byCompany[$company][$score] = $filteredByYear->where('nilai_akhir', $score)->count();
            }
        }

        $data = [
            'byTahun' => $byTahun,
            'byCompany' => $byCompany
        ];

        // dd(json_encode($data));

        return [
            'years' => $years,
            'data' => $data,
        ];;
    }

    public function get_summary_by_year($year)
    {
        // Call the function to get chart data based on these years
        $chartData = $this->get_chart_data_summary($year);

        // \Log::error($chartData['data']);

        // Return the data as JSON to be consumed by JavaScript
        return response()->json($chartData);
    }
}
