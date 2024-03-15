<?php

namespace App\Http\Controllers;

use App\Models\Stu_list;
use App\Models\Subject;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
use App\Models\Subject_stu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminOrTeacher');
    }

    public function index()
    {
        return view('teacher.subjects.index');
    }

    public function importData(Request $request)
    {
        $this->validate(
            $request,
            [
                // 'select_file'  => 'required|mimes:xls,xlsx'
            ],

            [
                // 'select_file.required' => __('.'),
            ]
        );

        $file = $request->select_file;
        Excel::import(new StudentImport, $file);

        return redirect()->back()->with('success', 'Import successful.!');
    }
    public function create()
    {

        $data = Stu_list::where('teacher_id', Auth::id())->get();

        return view('teacher.subjects.create', compact('data'));
    }

    public function store(Request $request)
    {


        $input_subject = [
            'teacher_id' => auth()->user()->id,
            'subject_id' => $request->subject_id,
            'subject_name' =>  $request->subject_name,
        ];


        $students = Stu_list::where('teacher_id', Auth::id())->get();

        foreach ($students as $student) {
            Subject_stu::create([
                'teacher_id' => auth()->user()->id,
                'subject_id' => $request->subject_id,
                'student_id' => $student->student_id,
                'name' => $student->name,
                
            ]);
        }

        
        Stu_list::where('teacher_id', Auth::id())->delete();

        Subject::create($input_subject);
        return redirect()->route('subject.index')->with('success','Subject Created Successfully !');

    }
}
