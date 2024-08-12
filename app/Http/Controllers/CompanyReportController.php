<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyReportController extends Controller
{
    public function index()
    {
        return view('company-report.index');
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
