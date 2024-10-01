<?php

namespace App\Http\Controllers;

use App\Models\MasterTahunPeriode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HelperController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        // Set the API URL once in the constructor
        $this->apiUrl = env('API_URL');
    }

    public function get_subordinates($ektp, $limit_date)
    {
        //Get all subordinates based on logged in user ektp
        $ektp_penilai =  $ektp;

        $api_url = $this->apiUrl . '/get_subordinates/' . $ektp_penilai . '/' . $limit_date;
        $subordinatesAPI = Http::timeout(50)
            ->get($api_url);

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

    public function get_active_periode()
    {
        // $today = Carbon::today();
        // $active_periode = MasterTahunPeriode::whereDate('start_date', '<=', $today)
        // ->whereDate('end_date', '>=', $today)
        // ->first(['id','tahun', 'periode']);

        $active_periode = MasterTahunPeriode::where('is_active', 1)
            ->first();

        if ($active_periode == null) {
            $active_periode = MasterTahunPeriode::orderBy('start_date', 'desc')
                ->orderBy('end_date', 'desc')
                ->first();
        }

        return $active_periode;
    }

    public function get_users()
    {
        $api_url = $this->apiUrl . '/get_users';
        $usersAPI = Http::timeout(50)
            ->get($api_url);

        $users = collect(json_decode($usersAPI->body())->data);

        return $users;
    }
}
