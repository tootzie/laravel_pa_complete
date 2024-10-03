<?php

namespace App\Http\Controllers;

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

    public function index()
    {
        $api_url = $this->apiUrl . '/get_all_company/';
        $companiesAPI = Http::timeout(50)
            ->get($api_url);
        $companies = collect(json_decode($companiesAPI->body())->data);

        return view('company-report.index', compact('companies'));
    }

    public function company_detail()
    {
        return view('company-report.detail');
    }

    public function company_department()
    {
        return view('company-report.department');
    }

    public function company_employee()
    {
        return view('company-report.employee');
    }
}
