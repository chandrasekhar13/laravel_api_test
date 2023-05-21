<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $standard = $request->standard;
        if ($standard && is_numeric($standard)) {

            $students = Student::where('standard', $standard)->paginate(5);
            if ($students->isNotEmpty()) {
                return response()->json(
                    [
                        "status" => 1,
                        "data" => $students,
                    ]);
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Bad Request',
                    ], 400
                );
            }
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Bad Request',
                ], 400
            );
        }
    }

    /**
     * fetch result of a student.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchResult(Request $request)
    {
        $student_id = $request->student_id;

        if ($student_id && is_numeric($student_id)) {
            try {
                $student = Student::find($student_id);

                $student_marks = $student->marks;
                $total_marks = 0;
                foreach ($student_marks as $student_mark) {

                    $total_marks += $student_mark->marks;
                }
                $percentage = round(($total_marks / 400) * 100, 2); //since 4 subjects total assumed to be 400

                if ($percentage < 35) {
                    $result = "Fail";
                } elseif ($percentage > 35 && $percentage < 60) {
                    $result = "Second Class";
                } elseif ($percentage > 60 && $percentage < 85) {
                    $result = "First Class";
                } elseif ($percentage > 85) {
                    $result = "Distinction";
                }
                return response()->json(
                    [
                        "student_name" => $student->student_name,
                        "percentage(%)" => $percentage,
                        "result" => $result,
                    ]
                );
            } catch (\Exception $e) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Bad Request',
                    ], 400
                );
            }
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Bad Request',
                ], 400
            );
        }
    }

}
