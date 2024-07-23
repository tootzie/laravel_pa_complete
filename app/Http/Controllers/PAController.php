<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartment;
use App\Models\MasterQuestionPA;
use App\Models\PA;
use Illuminate\Http\Request;

class PAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->data;
        $result = $data['score'];
        $dataLength = count($result);
        $arrSubaspect = [];
        $arrSubaspectSum = [];
        // $department_id = MasterDepartment::where('kode_department', '=', $data['kode_department'])->pluck('id')->first();


        for ($i = 0; $i < $dataLength; $i++) {
            array_push($arrSubaspect, $result[$i]['subaspect']);
        }


        foreach ($result as $key => $value) {
            $totalResult = 0;
            foreach ($value['items'] as $key => $item) {
                //Find in the pa table with the same question_id and department_id
                // $bobot = PA::where('id_master_pertanyaan', '=', $item['question_id'])->where('id_master_department', '=', $department_id)->pluck('bobot')->first();
                $bobot = MasterQuestionPA::where('id_question', '=', $item['question_id'])->pluck('bobot')->first();
                $input_value = 0;
                switch ($item['value']) {
                    case 1:
                        $input_value = 0.2;
                        break;
                    case 2:
                        $input_value = 0.4;
                        break;
                    case 3:
                        $input_value = 0.6;
                        break;
                    case 4:
                        $input_value = 0.8;
                        break;
                    case 5:
                        $input_value = 1;
                        break;

                    default:
                        # code...
                        break;
                }

                $result = $bobot * $input_value;
                $totalResult += $result;
            }
            //Add total result to the array
            array_push($arrSubaspectSum, $totalResult);
        }

        $totalAll = round(array_sum($arrSubaspectSum), 2) / 10000;
        $score = "";
        // Define the ranges and their corresponding values
        $ranges = [
            ['min' => 0.1, 'max' => 0.254, 'value' => 'E'],
            ['min' => 0.255, 'max' => 0.354, 'value' => 'D-'],
            ['min' => 0.355, 'max' => 0.414, 'value' => 'D'],
            ['min' => 0.415, 'max' => 0.474, 'value' => 'D+'],
            ['min' => 0.475, 'max' => 0.534, 'value' => 'C-'],
            ['min' => 0.535, 'max' => 0.594, 'value' => 'C'],
            ['min' => 0.595, 'max' => 0.654, 'value' => 'C+'],
            ['min' => 0.655, 'max' => 0.714, 'value' => 'B-'],
            ['min' => 0.715, 'max' => 0.774, 'value' => 'B'],
            ['min' => 0.775, 'max' => 0.824, 'value' => 'B+'],
            ['min' => 0.825, 'max' => 0.884, 'value' => 'A-'],
            ['min' => 0.885, 'max' => 0.943, 'value' => 'A'],
            ['min' => 0.94, 'max' => 10.00, 'value' => 'A+'],
            // Add more ranges as needed
        ];

        foreach ($ranges as $range) {
            // Check if $total falls within the current range
            if ($totalAll >= $range['min'] && $totalAll <= $range['max']) {
                $score = $range['value'];
            }
        }

        $arrResult = [
            "id_employee" => $data['id_employee'],
            "kode_question_category" => $data['kode_question_category'],
            "total_score" => $score,
            "total_all" => round(array_sum($arrSubaspectSum), 2),
            "score_details" => []
        ];
        for ($i = 0; $i < count($arrSubaspect); $i++) {
            $object = [
                "subaspect" => $arrSubaspect[$i],
                "total_value" => $arrSubaspectSum[$i]
            ];
            array_push($arrResult['score_details'], $object);
        }

        return response()->json(['data' => $arrResult], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['nama_department'] = MasterDepartment::where('id', '=', $id)->pluck('nama_department')->first();
        $data['kode_department'] = MasterDepartment::where('id', '=', $id)->pluck('kode_department')->first();
        $data['list'] = PA::where('id_master_department', '=', $id)->with('MasterPertanyaan', 'MasterPertanyaan.MasterSubAspek', 'MasterPertanyaan.MasterSubAspek.MasterAspek')->get();

        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
