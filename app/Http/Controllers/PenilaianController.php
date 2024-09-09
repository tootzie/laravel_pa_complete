<?php

namespace App\Http\Controllers;

use App\Models\DetailPA;
use App\Models\HeaderPA;
use App\Models\MasterAspek;
use App\Models\MasterQuestionPA;
use App\Models\MasterSubAspek;
use App\Models\MasterTahunPeriode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        // Get the search input
        $search = $request->input('search');

        //Get all subordinates based on logged in user ektp
        $ektp_penilai =  auth()->user()->ektp;
        // $subordinatesAPI = Http::timeout(50)
        //     ->get('http://172.26.11.16:8000/api/get_subordinates/'.$ektp_penilai);
        $subordinatesAPI = Http::timeout(50)
            ->get('http://192.168.0.128:8000/api/get_subordinates/'.$ektp_penilai);
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
        $ektp_subordinates = array_column($data_subordinates, 'ektp');

        //Get active master_tahun_periode
        $today = Carbon::today();
        $active_periode = MasterTahunPeriode::whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->first(['id','tahun', 'periode']);

        //Select all employees in $ektp_subordinates from  where id_master_tahun_periode is $active_periode
        $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)->whereIn('ektp_employee', $ektp_subordinates)->get();

        //If result is empty, add all employees name without any score to header_pa
        if($header_pa->isEmpty()) {
            $id_master_tahun_periode = $active_periode->id;
            //Store each employee to header_pa without score
            foreach ($ektp_subordinates as $ektp_subordinate) {
                if($ektp_subordinate != null) {
                    try {
                        HeaderPA::create([
                            'id_master_tahun_periode' => $id_master_tahun_periode,
                            'id_status_penilaian' => 100,
                            'ektp_employee' => $ektp_subordinate,
                            'nama_employee' => $data_subordinates[$ektp_subordinate]['name'],
                            'perusahaan' => $data_subordinates[$ektp_subordinate]['companyCode'],
                            'departemen' => $data_subordinates[$ektp_subordinate]['department'],
                            'kategori_pa' => $data_subordinates[$ektp_subordinate]['kategori_pa'],
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

        //Renew $header_pa variable
        $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)
            ->whereIn('ektp_employee', $ektp_subordinates)
            ->when($search, function ($query, $search) {
                // Get all columns from the 'header_pa' table
                $columns = Schema::getColumnListing('header_pa');

                $query->where(function($query) use ($search, $columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });

                return $query;
            })->paginate(10);

        return view('penilaian.index', compact('header_pa'));
    }

    public function penilaian_detail(Request $request)
    {
        $pa_employee = json_decode($request->pa_employee);

        //Get aspek kepribadian question
        $subaspeks = MasterSubAspek::where('id_master_aspek', 1)->get()->pluck('nama_subaspek','id');
        $pertanyaan_kepribadian_query = MasterQuestionPA::whereIn('id_master_subaspek', $subaspeks->keys())->get();
        $pertanyaan_kepribadian = $pertanyaan_kepribadian_query->groupBy('id_master_subaspek')->map(function ($questions, $subaspekId) use ($subaspeks) {
            return [
                'subaspek' => $subaspeks[$subaspekId],  // Get the subaspek name
                'questions' => $questions->map(function ($question) {
                    return [
                        'id' => $question->id_question,
                        'question' => $question->question,
                    ];
                })->toArray()
            ];
        })->values()->toArray();

        //Get aspek pekerjaan question
        $kategori_pa = $pa_employee->kategori_pa;
        $subaspeks = MasterSubAspek::where('id_master_aspek', 2)->get()->pluck('nama_subaspek','id');
        $pertanyaan_pekerjaan_query = MasterQuestionPA::whereIn('id_master_subaspek', $subaspeks->keys())->where('id_question', 'like', $kategori_pa . '.%')->get();
        $pertanyaan_pekerjaan = $pertanyaan_pekerjaan_query->groupBy('id_master_subaspek')->map(function ($questions, $subaspekId) use ($subaspeks) {
            return [
                'subaspek' => $subaspeks[$subaspekId],  // Get the subaspek name
                'questions' => $questions->map(function ($question) {
                    return [
                        'id' => $question->id_question,
                        'question' => $question->question,
                        'value' => null
                    ];
                })->toArray()  // Map questions
            ];
        })->values()->toArray();

        $questions = [
            "Kepribadian" => $pertanyaan_kepribadian,
            "Pekerjaan" => $pertanyaan_pekerjaan
        ];
        // dd($questions);
        return view('penilaian.penilaian-detail', compact(['pa_employee', 'questions']));
    }

    public function penilaian_detail_store(Request $request) {
        $pa_employee = json_decode($request->pa_employee);
        $kode_question_category = $pa_employee->kategori_pa;

        // Initialize the data array
        $data = [
            'data' => [
                'id_employee' => $pa_employee->ektp_employee,
                'kode_question_category' => $kode_question_category,
                'score' => []
            ]
        ];

        // Use the existing $questions variable that has been passed to the Blade view
        $questions = json_decode($request->questions, true);

        //Variables to store to detail_pa
        $id_header_pa = $pa_employee->id;
        $ektp_penilai = auth()->user()->ektp;
        $nama_penilai = auth()->user()->name;

        // Iterate over the submitted form data (all selected values)
        foreach ($request->input('question') as $questionId => $value) {
            // Determine the subaspect based on the questionId from the $questions variable
            $subaspek = $this->getSubaspekFromExistingQuestions($questions, $questionId);

            // Prepare the question data
            $questionData = [
                'question_id' => $questionId,
                'value' => $value
            ];

            // Check if the subaspect already exists in the score array
            $found = false;
            foreach ($data['data']['score'] as &$subaspect) {
                if ($subaspect['subaspect'] === $subaspek) {
                    $subaspect['items'][] = $questionData;
                    $found = true;
                    break;
                }
            }

            // If the subaspect does not exist yet, add a new entry
            if (!$found) {
                $data['data']['score'][] = [
                    'subaspect' => $subaspek,
                    'items' => [$questionData]
                ];
            }

            // Store scores to detail_pa
            DetailPA::create([
                'id_header_pa' => $id_header_pa,
                'id_master_question_pa' => $questionId,
                'ektp_penilai' => $ektp_penilai,
                'nama_penilai' => $nama_penilai,
                'score' => $value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }

        //Calculate nilai_awal from $data
        $PAController = new PAController();
        $response = $PAController->store($data);
        $responseData = $response->getData(true);
        $nilai_awal = $responseData['data']['total_score'];

        //Store nilai_awal to header_pa
        $header_pa = HeaderPA::where('id', $pa_employee->id)->first();
        $header_pa->update([
            'nilai_awal' => $nilai_awal,
            'id_status_penilaian' => 200,
            'updated_at' => Carbon::now(),
            'updated_by' => auth()->user()->name
        ]);

        session()->flash('success', "Penilaian berhasil ditambahkan. Nilai awal untuk $pa_employee->nama_employee : $nilai_awal");

        return redirect()->route('penilaian');

    }

    private function getSubaspekFromExistingQuestions($questions, $questionId)
    {
        foreach ($questions as $aspectType => $aspect) {
            foreach ($aspect as $subaspect) {
                foreach ($subaspect['questions'] as $question) {
                    if ($question['id'] == $questionId) {
                        return $subaspect['subaspek'];
                    }
                }
            }
        }

        return null; // Fallback in case the questionId is not found
    }

    public function penilaian_detail_awal()
    {
        return view('penilaian.penilaian-detail-awal');
    }
}
