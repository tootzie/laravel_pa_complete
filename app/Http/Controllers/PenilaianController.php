<?php

namespace App\Http\Controllers;

use App\Models\DetailPA;
use App\Models\HeaderPA;
use App\Models\MasterAspek;
use App\Models\MasterQuestionPA;
use App\Models\MasterSubAspek;
use App\Models\MasterTahunPeriode;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\alert;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $HelperController = new HelperController();

        // Get the search input
        $search = $request->input('search');

        //Get all subordinates based on logged in user ektp
        $ektpUser = auth()->user()->ektp;

        //Get active master_tahun_periode
        $active_periode = $HelperController->get_active_periode();
        // Check if today's date is between start_date and end_date
        $is_in_periode = false;
        if (Carbon::today()->between($active_periode->start_date, $active_periode->end_date)) {
            $is_in_periode = true;
        }

        //Masukkan semua KTP bawahan
        $data_subordinates = Cache::remember('data_subordinates_' . $ektpUser, 60 * 60, function () use ($HelperController, $ektpUser, $active_periode) {
            return $HelperController->get_subordinates($ektpUser, $active_periode->limit_date);
        });
        $ektp_subordinates = array_column($data_subordinates, 'ektp');

        //Filter KTP bawahan langsung (utk GM)
        $authEktp = auth()->user()->ektp;
        $filteredSubordinates = array_filter($data_subordinates, function ($subordinate) use ($authEktp) {
            return $subordinate['ektp_atasan'] == $authEktp;
        });
        if($filteredSubordinates != null) {
            // Extract all ektp values from the filtered subordinates
            $ktp_bawahan_langsung = array_column($filteredSubordinates, 'ektp');
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

        //Get data for Tahun - Periode filter
        $tahunPeriodeFilter = MasterTahunPeriode::all();

        //Get data for kategori PA filter
        $kategoriPAFilter = HeaderPA::where('id_master_tahun_periode', $active_periode->id)
        ->whereIn('ektp_employee', $ektp_subordinates)
        ->where('kategori_pa', '!=', '')
        ->distinct()
        ->pluck('kategori_pa');

        //Get nama atasan, jumlah anak buah, dan nama periode
        $jumlahAnakBuah = count($ektp_subordinates);

        $HelperController = new HelperController();
        $allAtasan = $HelperController->get_users();
        $selectedAtasan = $allAtasan->firstWhere('ektp_atasan', $ektpUser);
        $namaAtasan = $selectedAtasan ? $selectedAtasan->nama_atasan : '-';

        $startDate = Carbon::parse($active_periode->start_date)->translatedFormat('j F Y');
        $endDate = Carbon::parse($active_periode->end_date)->translatedFormat('j F Y');
        $stringPeriode = $startDate . ' s/d ' . $endDate;

        return view('penilaian.index', compact('header_pa', 'is_in_periode', 'ktp_bawahan_langsung', 'tahunPeriodeFilter', 'kategoriPAFilter', 'jumlahAnakBuah', 'namaAtasan', 'stringPeriode', 'data_subordinates'));
    }

    public function penilaian_detail($id, Request $request)
    {
        // Decrypt the ID
        try {
            $id = Crypt::decrypt($id);
        } catch (\Exception $e) {
            // Handle decryption errors, such as when the ID is tampered with
            abort(403, 'Unauthorized access');
        }

        $pa_employee = HeaderPA::where("id", $id)->first();

        //Get aspek kepribadian question
        $pertanyaan_kepribadian = $this->getKepribadianQuestion();

        //Get aspek pekerjaan question
        $pertanyaan_pekerjaan = $this->getPekerjaanQuestion($pa_employee);

        //Get kesimpulan dan saran
        $pertanyaan_kesimpulan = $this->getKesimpulanQuestion();

        $questions = [
            "Kepribadian" => $pertanyaan_kepribadian,
            "Pekerjaan" => $pertanyaan_pekerjaan,
        ];

        $id_header_pa = $pa_employee->id;
        $detailPA = DetailPA::where('id_header_pa', $id_header_pa)->get()->keyBy('id_master_question_pa');

        $ektpUser = $request->input('ektp');

        return view('penilaian.penilaian-detail', compact(['pa_employee', 'questions', 'detailPA', 'pertanyaan_kesimpulan', 'ektpUser']));
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
            \Log::error('subaspek question' . $questionId . ' = ' . $subaspek);

            // Prepare the question data
            $questionData = [
                'question_id' => $questionId,
                'value' => $value
            ];

            // Check if the subaspect already exists in the score array
            $found = false;
            foreach ($data['data']['score'] as &$allScores) {
                if ($allScores['subaspect'] == $subaspek) {
                    \Log::error('found true');
                    $allScores['items'][] = $questionData;
                    $found = true;
                    break;
                }
            }

            // If the subaspect does not exist yet, add a new entry
            if (!$found) {
                \Log::error('found false');
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

        //Store kesimpulan & saran
        foreach ($request->input('kesimpulan') as $kesimpulanId => $value) {
            if($value != null) {
                $detailPA = DetailPA::where("id_header_pa", $id_header_pa)->where("id_master_question_pa", $kesimpulanId)->first();
                if ($detailPA == null) {
                    DetailPA::create([
                        'id_header_pa' => $id_header_pa,
                        'id_master_question_pa' => $kesimpulanId,
                        'ektp_penilai' => $ektp_penilai,
                        'nama_penilai' => $nama_penilai,
                        'score' => 0,
                        'text_value' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    $detailPA->update([
                        'text_value' => $value,
                        'updated_at' => Carbon::now(),
                    ]);
                }
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
        $userRole = auth()->user()->userRole->id;

        if($userRole == 1) {
            //Pass ektp parameter
            $ektp = $request->input('ektp');
            return redirect()->route('penilaian-menu-by-user-detail', compact(['ektp']));
        } else {
            return redirect()->route('penilaian');
        }
    }

    public function penilaian_detail_preview(Request $request)
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
            \Log::error('subaspek question' . $questionId . ' = ' . $subaspek);

            // Prepare the question data
            $questionData = [
                'question_id' => $questionId,
                'value' => $value
            ];

            // Check if the subaspect already exists in the score array
            $found = false;
            foreach ($data['data']['score'] as &$allScores) {
                if ($allScores['subaspect'] == $subaspek) {
                    \Log::error('found true');
                    $allScores['items'][] = $questionData;
                    $found = true;
                    break;
                }
            }

            // If the subaspect does not exist yet, add a new entry
            if (!$found) {
                \Log::error('found false');
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

        //Store kesimpulan & saran
        foreach ($request->input('kesimpulan') as $kesimpulanId => $value) {
            if($value != null) {
                $detailPA = DetailPA::where("id_header_pa", $id_header_pa)->where("id_master_question_pa", $kesimpulanId)->first();
                if ($detailPA == null) {
                    DetailPA::create([
                        'id_header_pa' => $id_header_pa,
                        'id_master_question_pa' => $kesimpulanId,
                        'ektp_penilai' => $ektp_penilai,
                        'nama_penilai' => $nama_penilai,
                        'score' => 0,
                        'text_value' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    $detailPA->update([
                        'text_value' => $value,
                        'updated_at' => Carbon::now(),
                    ]);
                }
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

        // alert('hey');
        // return redirect()->back()->with('alert','hello');

        // return redirect()->back()->with('Data Tersimpan Otomatis', 'Nilai untuk ' . $pa_employee->nama_employee . $nilai_awal);
        session()->flash('success', "Nilai untuk $pa_employee->nama_employee : $nilai_awal");

        return redirect()->back();
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

        //Store kesimpulan & saran
        foreach ($request->input('kesimpulan') as $kesimpulanId => $value) {
            if($value != null) {
                $detailPA = DetailPA::where("id_header_pa", $id_header_pa)->where("id_master_question_pa", $kesimpulanId)->first();
                if ($detailPA == null) {
                    DetailPA::create([
                        'id_header_pa' => $id_header_pa,
                        'id_master_question_pa' => $kesimpulanId,
                        'ektp_penilai' => $ektp_penilai,
                        'nama_penilai' => $nama_penilai,
                        'score' => 0,
                        'text_value' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    $detailPA->update([
                        'text_value' => $value,
                        'updated_at' => Carbon::now(),
                    ]);
                }
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
        // Decrypt the ID
        try {
            $id = Crypt::decrypt($id);
        } catch (\Exception $e) {
            // Handle decryption errors, such as when the ID is tampered with
            abort(403, 'Unauthorized access');
        }

        $pa_employee = HeaderPA::where("id", $id)->first();

        // Fetch scores for the user
        $scores = DetailPA::where('id_header_pa', $pa_employee->id)->get()->pluck('score', 'id_master_question_pa');

        //Get aspek kepribadian question
        $pertanyaan_kepribadian = $this->getKepribadianQuestion();

        //Get aspek pekerjaan question
        $pertanyaan_pekerjaan = $this->getPekerjaanQuestion($pa_employee);

        //Get kesimpulan dan saran
        $pertanyaan_kesimpulan = $this->getKesimpulanQuestion();

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
        $statusPenilaian = $pa_employee->StatusPenilaian->kode_status;
        $stringRevisi = '';
        $defaultScore = '';

        if ($userRole == 2) {
            $stringRevisi = 'Revisi Head of Department';
            $defaultScore = $pa_employee->revisi_hod ?? '00';
        } else if ($userRole == 3) {
            $stringRevisi = 'Revisi GM';
            $defaultScore = $pa_employee->revisi_gm ?? '00';
        }

        //Variable for scores
        $scores = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'];

        $detailPA = DetailPA::where('id_header_pa', $id)->get()->keyBy('id_master_question_pa');

        return view('penilaian.penilaian-detail-revisi', compact(['pa_employee', 'questions', 'stringRevisi', 'scores', 'defaultScore', 'pertanyaan_kesimpulan', 'detailPA']));
    }

    public function penilaian_detail_revisi_store(Request $request)
    {
        $pa_employee = json_decode($request->pa_employee);

        $request->validate([
            'revisi_input' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value == '00') {
                        $fail('Please select a score.');
                    }
                },
            ],

        ]);

        $header_pa = HeaderPA::where('id', $pa_employee->id)->first();

        //Determine status penilaian
        $status_penilaian = 0;
        if ($request->stringRevisi == 'Revisi Head of Department') {
            $status_penilaian = 300;
            $header_pa->update([
                'revisi_hod' => $request->revisi_input,
                'id_status_penilaian' => $status_penilaian,
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->name
            ]);
        } else if ($request->stringRevisi == 'Revisi GM') {
            $status_penilaian = 400;
            $header_pa->update([
                'revisi_gm' => $request->revisi_input,
                'id_status_penilaian' => $status_penilaian,
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->name
            ]);
        }

        $id_header_pa = $pa_employee->id;
        $ektp_penilai = auth()->user()->ektp;
        $nama_penilai = auth()->user()->name;

        //Store kesimpulan & saran
        foreach ($request->input('kesimpulan') as $kesimpulanId => $value) {
            if($value != null) {
                $detailPA = DetailPA::where("id_header_pa", $id_header_pa)->where("id_master_question_pa", $kesimpulanId)->first();
                if ($detailPA == null) {
                    DetailPA::create([
                        'id_header_pa' => $id_header_pa,
                        'id_master_question_pa' => $kesimpulanId,
                        'ektp_penilai' => $ektp_penilai,
                        'nama_penilai' => $nama_penilai,
                        'score' => 0,
                        'text_value' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    $detailPA->update([
                        'text_value' => $value,
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }

        session()->flash('success', "Penilaian berhasil ditambahkan untuk $pa_employee->nama_employee");

        $userRole = auth()->user()->userRole->id;

        if($userRole == 1) {
            //Pass ektp parameter
            $ektp = $request->input('ektp');
            return redirect()->route('penilaian-menu-by-user-detail', compact(['ektp']));
        } else {
            return redirect()->route('penilaian');
        }


    }

    public function penilaian_detail_revisi_all($id, Request $request)
    {
        // Decrypt the ID
        try {
            $id = Crypt::decrypt($id);
        } catch (\Exception $e) {
            // Handle decryption errors, such as when the ID is tampered with
            abort(403, 'Unauthorized access');
        }

        $pa_employee = HeaderPA::where("id", $id)->first();

        // Fetch scores for the user
        $scores = DetailPA::where('id_header_pa', $pa_employee->id)->get()->pluck('score', 'id_master_question_pa');

        //Get aspek kepribadian question
        $pertanyaan_kepribadian = $this->getKepribadianQuestion();

        //Get aspek pekerjaan question
        $pertanyaan_pekerjaan = $this->getPekerjaanQuestion($pa_employee);

        //Get kesimpulan dan saran
        $pertanyaan_kesimpulan = $this->getKesimpulanQuestion();

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
        $statusPenilaian = $pa_employee->StatusPenilaian->kode_status;
        $stringRevisi = '';
        $defaultScore = '';

        $defaultScoreHod = $pa_employee->revisi_hod ?? '00';
        $defaultScoreGM = $pa_employee->revisi_gm ?? '00';
        $defaultScoreAkhir = $pa_employee->nilai_akhir ?? '00';

        //Variable for scores
        $scores = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'E'];

        //Pass ektp parameter
        $ektp = $request->input('ektp');

        $detailPA = DetailPA::where('id_header_pa', $id)->get()->keyBy('id_master_question_pa');

        return view('penilaian.penilaian-detail-revisi-all', compact(['pa_employee', 'questions', 'stringRevisi', 'scores', 'defaultScoreHod', 'defaultScoreGM', 'defaultScoreAkhir', 'ektp', 'pertanyaan_kesimpulan', 'detailPA']));
    }

    public function penilaian_detail_revisi_store_all(Request $request)
    {
        $pa_employee = json_decode($request->pa_employee);
        $userRole = auth()->user()->userRole->id;

        if($userRole == 3) {
            $request->validate([
                'revisi_input_hod' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value == '00') {
                            $fail('Please select a score.');
                        }
                    },
                ],
                'revisi_input_gm' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value == '00') {
                            $fail('Please select a score.');
                        }
                    },
                ],
            ]);
        }

        // if($userRole == 1){
        //     $request->validate([
        //         'revisi_input_nilai_akhir' => [
        //             'required',
        //             function ($attribute, $value, $fail) {
        //                 if ($value == '00') {
        //                     $fail('Please select a score.');
        //                 }
        //             },
        //         ],
        //     ]);
        // }

        $header_pa = HeaderPA::where('id', $pa_employee->id)->first();

        //Determine status penilaian
        if($userRole == 1) {
            if($request->nilai_akhir != 00) {
                $status_penilaian = 500;
                $header_pa->update([
                    'id_status_penilaian' => $status_penilaian,
                ]);
            }

            $header_pa->update([
                'revisi_hod' => $request->revisi_input_hod == '00' ? null :$request->revisi_input_hod,
                'revisi_gm' => $request->revisi_input_gm == '00' ? null :$request->revisi_input_gm,
                'nilai_akhir' => $request->revisi_input_nilai_akhir == '00' ? null :$request->revisi_input_nilai_akhir,
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->name
            ]);
        } else {
            $status_penilaian = 400;
            $header_pa->update([
                'revisi_hod' => $request->revisi_input_hod,
                'revisi_gm' => $request->revisi_input_gm,
                'id_status_penilaian' => $status_penilaian,
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->name
            ]);
        }

        $id_header_pa = $pa_employee->id;
        $ektp_penilai = auth()->user()->ektp;
        $nama_penilai = auth()->user()->name;

        //Store kesimpulan & saran
        foreach ($request->input('kesimpulan') as $kesimpulanId => $value) {
            if($value != null) {
                $detailPA = DetailPA::where("id_header_pa", $id_header_pa)->where("id_master_question_pa", $kesimpulanId)->first();
                if ($detailPA == null) {
                    DetailPA::create([
                        'id_header_pa' => $id_header_pa,
                        'id_master_question_pa' => $kesimpulanId,
                        'ektp_penilai' => $ektp_penilai,
                        'nama_penilai' => $nama_penilai,
                        'score' => 0,
                        'text_value' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    $detailPA->update([
                        'text_value' => $value,
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }

        session()->flash('success', "Penilaian berhasil ditambahkan untuk $pa_employee->nama_employee");

        if($userRole == 1) {
            //Pass ektp parameter
            $ektp = $request->input('ektp');
            return redirect()->route('penilaian-menu-by-user-detail', compact(['ektp']));
        } else {
            return redirect()->route('penilaian');
        }
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

    private function getKesimpulanQuestion()
    {
        $subaspeks = MasterSubAspek::where('id_master_aspek', 3)->get()->pluck('nama_subaspek', 'id');
        $pertanyaan_kesimpulan_query = MasterQuestionPA::whereIn('id_master_subaspek', $subaspeks->keys())->get();
        $pertanyaan_kesimpulan = $pertanyaan_kesimpulan_query->groupBy('id_master_subaspek')->map(function ($questions, $subaspekId) use ($subaspeks) {
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

        return $pertanyaan_kesimpulan;
    }
}
