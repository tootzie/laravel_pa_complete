<?php

namespace App\Http\Controllers;

use App\Models\HeaderPA;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class PenilaianByUserController extends Controller
{
    public function index()
    {
        $HelperController = new HelperController();
        $users = Cache::remember('data_users', 60 * 60, function () use ($HelperController) {
            return $HelperController->get_users();
        });

        return view('penilaian-by-user.index', compact(['users']));
    }

    public function detail(Request $request)
    {
        if($request->isIndex != null) {
            Cache::flush();
            $request->validate([
                'user_choice' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value == '00') {
                            $fail('Please select a user.');
                        }
                    },
                ],
            ]);
        }

        $HelperController = new HelperController();

        // Get the search input
        $search = $request->input('search');

        //Get all subordinates based on logged in user ektp
        $ektpUser = $request->input('ektp');

        //Get active master_tahun_periode
        $active_periode = $HelperController->get_active_periode();

        $data_subordinates = Cache::remember('data_subordinates_' . $ektpUser, 60 * 60, function () use ($HelperController, $ektpUser, $active_periode) {
            return $HelperController->get_subordinates($ektpUser, $active_periode->limit_date);
        });

        $ektp_subordinates = array_column($data_subordinates, 'ektp');

        $is_in_periode = false;

        // Check if today's date is between start_date and end_date
        if (Carbon::today()->between($active_periode->start_date, $active_periode->end_date)) {
            $is_in_periode = true;
        }

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

        //Renew $header_pa variable
        $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)
            ->whereIn('ektp_employee', $ektp_subordinates)
            ->when($search, function ($query, $search) {
                // Get all columns from the 'header_pa' table
                $columns = Schema::getColumnListing('header_pa');

                $query->where(function ($query) use ($search, $columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });

                return $query;
            })->orderBy('nama_employee', 'asc')->paginate(10);

            //Get nama atasan, jumlah anak buah, dan nama periode
            $jumlahAnakBuah = count($ektp_subordinates);

            $HelperController = new HelperController();
            $allAtasan = $HelperController->get_users();
            $selectedAtasan = $allAtasan->firstWhere('ektp_atasan', $ektpUser);
            $namaAtasan = $selectedAtasan ? $selectedAtasan->nama_atasan : '-';

            $startDate = Carbon::parse($active_periode->start_date)->translatedFormat('j F Y');
            $endDate = Carbon::parse($active_periode->end_date)->translatedFormat('j F Y');
            $stringPeriode = $startDate . ' s/d ' . $endDate;

        return view('penilaian-by-user.detail', compact('header_pa', 'is_in_periode', 'ektpUser', 'jumlahAnakBuah', 'namaAtasan', 'stringPeriode', 'data_subordinates'));
    }
}
