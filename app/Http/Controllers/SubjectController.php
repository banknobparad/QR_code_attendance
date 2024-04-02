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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminOrTeacher');
    }

    public function index()
    {
        $subjects = Subject::with('subject_stu')->where('teacher_id', auth()->user()->id)->where('subject_id', '!=', null)->get();
        // dd($subjects->toArray());
        return view('teacher.subjects.index', compact('subjects'));
    }

    public function getStudents($subject_id)
{
    $students = Subject::findOrFail($subject_id)->subject_stu;
    return response()->json(['students' => $students]);
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


    public function importInsert(Request $request)
    {
        $request->validate([
            // 'No'   => 'required',
            // 'Name' => 'required',
            // 'Sex'  => 'required',
            // 'Age'  => 'required'
        ]);
        if ($request->get('Student_id')) {
            $codesExists = $request->get('Student_id');
            $data = Stu_list::where('id', $codesExists)->count();
            if ($data > 0) {
                return redirect()->back()->with('codesExists', "Exit already.!");
            } else {
                $importInsert = [
                    'teacher_id' => auth()->user()->id,
                    'Name' => $request->Name,
                    'Student_id' => $request->Student_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                Stu_list::insert($importInsert);
                return redirect()->back()->with('importInsert', 'Insert Sucessful.!');
            }
        }
    }

    public function importUpdate(Request $request)
    {
        $importUpdate = [
            'teacher_id' => auth()->user()->id,
            'id'    =>    $request->idUpdate,
            'Name'     =>    $request->Name,
            'Student_id' => $request->Student_id,
            'updated_at' => Carbon::now(),
        ];
        Stu_list::where('id', $request->idUpdate)->update($importUpdate);
        return redirect()->back()->with('importUpdate', 'Update Successfull.!');
    }

    public function importDelete($importID)
    {
        Stu_list::where('id', $importID)->delete();
        return redirect()->back()->with('importDelete', 'Delect Successfull.!');
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
        return redirect()->route('subject.index')->with('success', 'Subject Created Successfully !');
    }

    public function show($subject_id)
    {
        $subject = Subject::with('subject_stu')->where('subject_is', $subject_id);

        if (!$subject) {
            return response()->json(['error' => 'Subject not found'], 404);
        }

        return response()->json($subject);
    }

    public function showedit($subject_id)
    {
        $edit_subject = Subject::with('subject_stu')->where('subject_id', $subject_id)->where('teacher_id', auth()->user()->id)->firstOrFail();


        // dd($edit_subject->toArray());
        return view('teacher.subjects.edit', compact('edit_subject'));
    }

    public function edit(Request $request, $subject_id)
    {
        $request->validate([
            'subject_name' => 'required', // ตรวจสอบว่าชื่อเรื่องไม่ว่าง
        ]);

        $subject = Subject::where('subject_id', $subject_id)
            ->where('teacher_id', auth()->user()->id)
            ->firstOrFail();

        // ตรวจสอบว่ามีการเปลี่ยนแปลงเลข subject_id หรือไม่
        if ($subject->subject_id != $request->subject_id) {
            // อัพเดทเลข subject_id
            $subject->subject_id = $request->subject_id;
            $subject->save();

            // อัพเดทเลข subject_id ของนักเรียนในตาราง subject_stus
            $students = Subject_stu::where('teacher_id', auth()->user()->id)->get();
            foreach ($students as $student) {
                $subject_stu = Subject_stu::where('teacher_id', auth()->user()->id)
                    ->where('subject_id', $subject_id)
                    ->where('student_id', $student->student_id)
                    ->first();
                if ($subject_stu) {
                    $subject_stu->subject_id = $request->subject_id;
                    $subject_stu->save();
                }
            }
        }

        // อัพเดทชื่อเรื่อง
        $subject->subject_name = $request->subject_name;
        $subject->save();

        return redirect()->route('subject.index')->with('success', 'Subject Updated Successfully !');
    }

    public function updateAdd(Request $request)
    {
        $request->validate([
            // 'No'   => 'required',
            // 'Name' => 'required',
            // 'Sex'  => 'required',
            // 'Age'  => 'required'
        ]);


        if ($request->get('Student_id')) {
            $codesExists = $request->get('Student_id');
            $data = Stu_list::where('id', $codesExists)->count();
            if ($data > 0) {
                return redirect()->back()->with('codesExists', "Exit already.!");
            } else {
                $importInsert = [
                    'teacher_id' => auth()->user()->id,
                    'subject_id' => $request->subject_id,
                    'Name' => $request->Name,
                    'Student_id' => $request->Student_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                subject_stu::insert($importInsert);
                return redirect()->back()->with('importInsert', 'Insert Sucessful.!');
            }
        }
    }

    public function updateedit(Request $request)
    {
        $importUpdate = [
            'teacher_id' => auth()->user()->id,
            'id'    =>    $request->idUpdate,
            'Name'     =>    $request->Name,
            'Student_id' => $request->Student_id,
            'updated_at' => Carbon::now(),
        ];
        subject_stu::where('id', $request->idUpdate)->update($importUpdate);
        return redirect()->back()->with('importUpdate', 'Update Successfull.!');
    }

    public function editDelete($id)
    {
        subject_stu::where('id', $id)->delete();
        return redirect()->back()->with('importDelete', 'Delect Successfull.!');
    }

}
