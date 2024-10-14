<?php

namespace App\Http\Controllers;

use App\Models\HeaderPA;
use App\Models\MasterPerusahaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function company_department()
    {
        return view('company-report.department');
    }

    public function company_employee()
    {
        return view('company-report.employee');
    }

    public function get_chart_data_company( $company, $year = null) {
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
