<?php

namespace App\Http\Controllers;

use App\Mail\Mail;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as FacadesMail;

class PDFController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["email"] = "pa.wingscorp@gmail.com";
        $data["title"] = "Assessement Result";
        $data["body"] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum";

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('emails.myPdf', $data);


        // $pdf = PDF::loadView('emails.myTestMail', $data);
        $data["pdf"] = $pdf;

        FacadesMail::to($data["email"])->send(new Mail($data));

        // Mail::to($data["email"])->send(new Mail($data));

        dd('Mail sent successfully');
    }
}
