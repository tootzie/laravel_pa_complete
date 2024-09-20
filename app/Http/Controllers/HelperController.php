<?php

namespace App\Http\Controllers;

use App\Models\MasterTahunPeriode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HelperController extends Controller
{
    public function get_subordinates() {
        //Get all subordinates based on logged in user ektp
        $ektp_penilai =  auth()->user()->ektp;
        $subordinatesAPI = Http::timeout(50)
            ->get('http://172.26.11.17:8000/api/get_subordinates/'.$ektp_penilai);

        $subordinates = collect(json_decode($subordinatesAPI->body())->data);

        //Save all subordinates data
        $data_subordinates = [];
        foreach ($subordinates as $subordinate) {
            $data_subordinates[$subordinate->ektp] = [
                    'ektp' => $subordinate->ektp,
                    'name' => $subordinate->name,
                    'companyCode' => $subordinate->CompanyCode,
                    'office' => $subordinate->Office,
                    'department' => $subordinate->Department,
                    'paCode' => $subordinate->PACode,
                    'ektp_atasan' => $subordinate->ektp_atasan,
                    'nama_atasan' => $subordinate->nama_atasan,

            ];
        }

        return $data_subordinates;
    }

    public function get_active_periode() {
        $today = Carbon::today();
        $active_periode = MasterTahunPeriode::whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->first(['id','tahun', 'periode']);

        return $active_periode;
    }
}
