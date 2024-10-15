<?php

namespace App\Http\Controllers;

use App\Models\HeaderPA;
use App\Models\MasterPerusahaan;
use App\Models\MasterTahunPeriode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class CompanyReportController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        // Set the API URL once in the constructor
        $this->apiUrl = env('API_URL');
    }

    public function index(Request $request)
    {
        $HelperController = new HelperController();
        $companies = $HelperController->get_all_companies();

        // Get the search query input from the request
        $search = $request->input('search');

        // Filter companies based on the search query (if present)
        if ($search) {
            $companies = $companies->filter(function ($company) use ($search) {
                return str_contains(strtolower($company->companycode), strtolower($search));
            });
        }

        return view('company-report.index', compact('companies', 'search'));
    }

    public function company_detail($company, Request $request)
    {
        $master_perusahaan = MasterPerusahaan::where('kode_perusahaan', $company)->first();
        $HelperController = new HelperController();
        $departments = $HelperController->get_departments($company);

        // Get the search query input from the request
        $search = $request->input('search');

        // Filter companies based on the search query (if present)
        if ($search) {
            $departments = $departments->filter(function ($department) use ($search) {
                return str_contains(strtolower($department->department), strtolower($search));
            });
        }

        $chartData = $this->get_chart_data_company($company);
        $years = array_reverse($chartData['years']);

        return view('company-report.detail', compact(['master_perusahaan', 'departments', 'search', 'chartData', 'years']));
    }

    public function company_department($company, $department, Request $request)
    {
        $master_perusahaan = MasterPerusahaan::where('kode_perusahaan', $company)->first();
        $HelperController = new HelperController();

        // Get the search query input from the request
        $search = $request->input('search');

        $chartData = $this->get_chart_data_department($company, $department);
        $years = array_reverse($chartData['years']);

        //Periode
        $active_periode = $HelperController->get_active_periode();
        $is_in_periode = false;
        // Check if today's date is between start_date and end_date
        if (Carbon::today()->between($active_periode->start_date, $active_periode->end_date)) {
            $is_in_periode = true;
        }


        //Get data table
        $master_tahun_periode = MasterTahunPeriode::where('tahun', $years[0])->pluck('id');

        $header_pa = HeaderPA::with('MasterTahunPeriode')
            ->where('perusahaan', $company)
            ->where('departemen', $department)
            ->whereIn('id_master_tahun_periode', $master_tahun_periode)
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
            ->orderBy('nama_employee', 'asc')->paginate(10);


        return view('company-report.department', compact(['master_perusahaan', 'department', 'search', 'chartData', 'years', 'header_pa', 'is_in_periode']));
    }

    public function company_employee()
    {
        return view('company-report.employee');
    }

    public function get_chart_data_company($company, $year = null)
    {
        $inputYear = '';
        if ($year != null) {
            $inputYear = $year;
        } else {
            $inputYear = Carbon::now()->format('Y');
        }


        $years = [$inputYear - 1, $inputYear];
        $scores = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'];

        $byTahun = [];

        $headerData = HeaderPA::with('MasterTahunPeriode')
            ->where('perusahaan', $company)
            ->whereHas('MasterTahunPeriode', function ($query) use ($years) {
                $query->whereIn('tahun', $years);
            })
            ->get();


        //Group by year and count scores
        foreach ($years as $year) {
            $byTahun[$year] = [];
            foreach ($scores as $score) {
                // Filter records for the selected year
                $filteredByYear = $headerData->filter(function ($record) use ($year) {
                    return $record->masterTahunPeriode->tahun == $year;
                });

                $byTahun[$year][$score] = $filteredByYear->where('nilai_akhir', $score)->count();
                \Log::error($byTahun[$year][$score]);
            }
        }

        $data = [
            'years' => $years,
            'data' => $byTahun,
        ];

        return $data;
    }

    public function get_chart_data_department($company, $department, $year = null)
    {
        $inputYear = '';
        if ($year != null) {
            $inputYear = $year;
        } else {
            $inputYear = Carbon::now()->format('Y');
        }


        $years = [$inputYear - 1, $inputYear];
        $scores = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'];

        $byTahun = [];

        $headerData = HeaderPA::with('MasterTahunPeriode')
            ->where('perusahaan', $company)
            ->where('departemen', $department)
            ->whereHas('MasterTahunPeriode', function ($query) use ($years) {
                $query->whereIn('tahun', $years);
            })
            ->get();


        //Group by year and count scores
        foreach ($years as $year) {
            $byTahun[$year] = [];
            foreach ($scores as $score) {
                // Filter records for the selected year
                $filteredByYear = $headerData->filter(function ($record) use ($year) {
                    return $record->masterTahunPeriode->tahun == $year;
                });

                $byTahun[$year][$score] = $filteredByYear->where('nilai_akhir', $score)->count();
                \Log::error($byTahun[$year][$score]);
            }
        }

        $data = [
            'years' => $years,
            'data' => $byTahun,
        ];

        return $data;
    }
}
