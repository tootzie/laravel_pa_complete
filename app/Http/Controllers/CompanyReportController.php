<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CompanyReportController extends Controller
{
    public function index()
    {
        $companiesAPI = Http::timeout(50)
            ->get('http://172.26.11.17:8000/api/get_all_company');
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
