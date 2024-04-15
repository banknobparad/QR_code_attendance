<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('admin.index');
    }
    public function home()
    {
        $users = User::where('role', '!=', null)->get();
        // dd($users->toArray());
        return view('home', compact('users'));
    }

    public function edit($id)
    {
        $user = User::all()->find($id);
        return view('admin.edit', compact('user'));
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        return redirect()->back()->with('success', 'Created user  successfully.');
    }
}
