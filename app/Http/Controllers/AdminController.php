<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $branch = Branch::all();
        $year = Year::all();

        return view('admin.index', compact('year', 'branch'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required', 'regex:/^[a-zA-Zก-๏]+(\s[a-zA-Zก-๏]+)?$/u', 'max:100',
                'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
                'password' => 'required', 'string', 'min:8', 'confirmed',
                'role' => 'required',
            ],
            [
                'name.required' => 'กรุณากรอกชื่อ-นามสกุล',
                'name.max' => 'ชื่อ-นามสกุลยาวเกินไป (สูงสุด 100 ตัวอักษร)',
                'name.regex' => 'กรุณากรอกชื่อให้ถูกต้อง และสามารถเว้นวรรคได้แค่ 1 ครั้ง',

                'email.required' => 'กรุณากรอกอีเมล',
                'email.email' => 'อีเมลไม่ถูกต้อง',
                'email.max' => 'อีเมลยาวเกินไป (สูงสุด 255 ตัวอักษร)',
                'email.unique' => 'อีเมลนี้ถูกลงทะเบียนไปแล้ว',

                'password.required' => 'กรุณากรอกรหัสผ่าน',
                'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',

                'role' => 'กรุณาเลือกบทบาท'
            ]
        );

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'student_id' => $request->student_id,
            'branch_id' => $request->branch_id,
            'year_id' => $request->year_id,
            'phone_number' => $request->phone_number,
            'email_verified_at' => now(),
            'role' => $request->role,
        ];

        User::create($user);

        return redirect()->back()->with('success', 'เพิ่ม User สำเร็จ');
    }

    public function edit($id)
    {
        $user = User::all()->find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::all()->find($request->id);
        if ($user->email == $request->email) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|string',
            ]);
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;

            $user->save();
            return redirect('home')->with('success', 'Updated user  successfully.');
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|string',
            ]);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;

            $user->save();
            return redirect('home')->with('success', 'Updated user  successfully.');
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('home')->with('success', 'Deleted user  successfully.');
    }
}
