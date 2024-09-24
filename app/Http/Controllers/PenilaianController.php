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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $HelperController = new HelperController();

        // Get the search input
        $search = $request->input('search');

        //Get all subordinates based on logged in user ektp
        $data_subordinates = $HelperController->get_subordinates();
        $ektp_subordinates = array_column($data_subordinates, 'ektp');

        //Get active master_tahun_periode
        $active_periode = $HelperController->get_active_periode();

        //Select all employees in $ektp_subordinates from where id_master_tahun_periode is $active_periode
        // $header_pa = HeaderPA::where('id_master_tahun_periode', $active_periode->id)->whereIn('ektp_employee', $ektp_subordinates)->get();

        //If result is empty, add all employees name without any score to header_pa
        // if($header_pa->isEmpty()) {
        //     $id_master_tahun_periode = $active_periode->id;
        //     //Store each employee to header_pa without score
        //     foreach ($ektp_subordinates as $ektp_subordinate) {
        //         if($ektp_subordinate != null) {
        //             try {
        //                 HeaderPA::create([
        //                     'id_master_tahun_periode' => $id_master_tahun_periode,
        //                     'id_status_penilaian' => 100,
        //                     'ektp_employee' => $ektp_subordinate,
        //                     'nama_employee' => $data_subordinates[$ektp_subordinate]['name'],
        //                     'perusahaan' => $data_subordinates[$ektp_subordinate]['companyCode'],
        //                     'departemen' => $data_subordinates[$ektp_subordinate]['department'],
        //                     'kategori_pa' => $data_subordinates[$ektp_subordinate]['paCode'],
        //                     'created_at' => Carbon::now(),
        //                     'updated_at' => Carbon::now(),
        //                     'updated_by' => 'Sistem'
        //                 ]);


        //             } catch (\Exception $e) {
        //                 // Output the exception message for debugging
        //                 dd($e->getMessage());
        //             }
        //         }
        //     }

        // }

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
            })->paginate(10);

        return view('penilaian.index', compact('header_pa'));
    }

    public function penilaian_detail($id)
    {
        $pa_employee = HeaderPA::where("id", $id)->first();

        //Get aspek kepribadian question
        $pertanyaan_kepribadian = $this->getKepribadianQuestion();

        //Get aspek pekerjaan question
        $pertanyaan_pekerjaan = $this->getPekerjaanQuestion($pa_employee);

        $questions = [
            "Kepribadian" => $pertanyaan_kepribadian,
            "Pekerjaan" => $pertanyaan_pekerjaan
        ];

        $id_header_pa = $pa_employee->id;
        $detailPA = DetailPA::where('id_header_pa', $id_header_pa)->get()->keyBy('id_master_question_pa');

        return view('penilaian.penilaian-detail', compact(['pa_employee', 'questions', 'detailPA']));
    }

    public function penilaian_detail_store(Request $request)
    {
        // Use the existing $questions variable that has been passed to the Blade view
        $questions = json_decode($request->questions, true);

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
            foreach ($data['data']['score'] as $subaspect) {
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

            // Store scores to detail_pa if detail with id_header_pa is not available yet
            $detailPA = DetailPA::where("id_header_pa", $id_header_pa)->where("id_master_question_pa", $questionId)->first();
            if ($detailPA == null) {
                DetailPA::create([
                    'id_header_pa' => $id_header_pa,
                    'id_master_question_pa' => $questionId,
                    'ektp_penilai' => $ektp_penilai,
                    'nama_penilai' => $nama_penilai,
                    'score' => $value,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            } else {
                $detailPA->update([
                    'score' => $value,
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // Initialize an array to store validation errors
        $validationErrors = [];

        // Loop through categories (e.g., "Kepribadian", "Pekerjaan")
        foreach ($questions as $category => $subaspects) {
            // Loop through each subaspect within the category
            foreach ($subaspects as $subaspect) {
                // Loop through each question in the subaspect
                foreach ($subaspect['questions'] as $question) {
                    $questionId = $question['id'];

                    // Check if the question has an answer
                    if (!isset($request->input('question')[$questionId])) {
                        // If a question is not answered, add an error message for that question
                        $validationErrors['question.' . $questionId] = "Silakan isi jawaban";
                    }
                }
            }
        }

        // If there are validation errors, redirect back with the errors
        if (!empty($validationErrors)) {
            session()->flash('danger', "Semua pertanyaan wajib diisi");
            return redirect()->back()->withErrors($validationErrors)->withInput();
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

    public function penilaian_detail_autosave(Request $request)
    {
        $pa_employee = json_decode($request->pa_employee);
        $kode_question_category = $pa_employee->kategori_pa;
        // \Log::info(json_encode($kode_question_category));

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

        foreach ($request->input('question') as $questionId => $value) {
            \Log::error('foreach in');
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

            // Store scores to detail_pa if detail with id_header_pa is not available yet
            $detailPA = DetailPA::where("id_header_pa", $id_header_pa)->where("id_master_question_pa", $questionId)->first();
            if ($detailPA == null) {
                \Log::error('detailPA null');
                DetailPA::create([
                    'id_header_pa' => $id_header_pa,
                    'id_master_question_pa' => $questionId,
                    'ektp_penilai' => $ektp_penilai,
                    'nama_penilai' => $nama_penilai,
                    'score' => $value,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            } else {
                \Log::error('detailPA update');
                $detailPA->update([
                    'score' => $value,
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
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

    public function penilaian_detail_revisi($id)
    {
        $pa_employee = HeaderPA::where("id", $id)->first();

        // Fetch scores for the user
        $scores = DetailPA::where('id_header_pa', $pa_employee->id)->get()->pluck('score', 'id_master_question_pa');

        //Get aspek kepribadian question
        $pertanyaan_kepribadian = $this->getKepribadianQuestion();

        //Get aspek pekerjaan question
        $pertanyaan_pekerjaan = $this->getPekerjaanQuestion($pa_employee);

        // Update kepribadian questions with scores
        $pertanyaan_kepribadian = array_map(function ($subaspek) use ($scores) {
            return [
                'subaspek' => $subaspek['subaspek'],
                'questions' => array_map(function ($question) use ($scores) {
                    return [
                        'id' => $question['id'],
                        'question' => $question['question'],
                        'score' => $scores->get($question['id'])  // Add score if it exists
                    ];
                }, $subaspek['questions'])
            ];
        }, $pertanyaan_kepribadian);

        // Update pekerjaan questions with scores
        $pertanyaan_pekerjaan = array_map(function ($subaspek) use ($scores) {
            return [
                'subaspek' => $subaspek['subaspek'],
                'questions' => array_map(function ($question) use ($scores) {
                    return [
                        'id' => $question['id'],
                        'question' => $question['question'],
                        'score' => $scores->get($question['id'])  // Add score if it exists
                    ];
                }, $subaspek['questions'])
            ];
        }, $pertanyaan_pekerjaan);

        // Combine results
        $questions = [
            "Kepribadian" => $pertanyaan_kepribadian,
            "Pekerjaan" => $pertanyaan_pekerjaan
        ];

        //String Revisi
        $userRole = auth()->user()->userRole->id;
        $statusPenilaian = $pa_employee->id_status_penilaian;
        $stringRevisi = '';

        if ($userRole == 2) {
            $stringRevisi = 'Revisi Head of Department';
        } else if ($userRole == 3) {
            $stringRevisi = 'Revisi GM';
        }

        return view('penilaian.penilaian-detail-revisi', compact(['pa_employee', 'questions', 'stringRevisi']));
    }

    public function penilaian_detail_revisi_store(Request $request)
    {
        $pa_employee = json_decode($request->pa_employee);

        // Validate the request
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        // Retrieve the selected value
        $nilai_revisi = $validated['status'];

        //Determine status penilaian
        $status_penilaian = 0;
        if ($request->stringRevisi == 'Revisi Head of Department') {
            $status_penilaian = 300;
        } else if ($request->stringRevisi == 'Revisi GM') {
            $status_penilaian = 400;
        }

        //Update header_pa
        $header_pa = HeaderPA::where('id', $pa_employee->id)->first();
        $header_pa->update([
            'revisi_hod' => $nilai_revisi,
            'id_status_penilaian' => $status_penilaian,
            'updated_at' => Carbon::now(),
            'updated_by' => auth()->user()->name
        ]);

        session()->flash('success', "Penilaian berhasil ditambahkan. Nilai revisi untuk $pa_employee->nama_employee : $nilai_revisi");

        return redirect()->route('penilaian');
    }

    private function getKepribadianQuestion()
    {
        $subaspeks = MasterSubAspek::where('id_master_aspek', 1)->get()->pluck('nama_subaspek', 'id');
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

        return $pertanyaan_kepribadian;
    }

    private function getPekerjaanQuestion($pa_employee)
    {
        $kategori_pa = $pa_employee->kategori_pa;
        $subaspeks = MasterSubAspek::where('id_master_aspek', 2)->get()->pluck('nama_subaspek', 'id');
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

        return $pertanyaan_pekerjaan;
    }
}
