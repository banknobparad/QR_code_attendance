<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::user()->role === 'Administrator') {
            $users = User::where('role', '!=', 'Administrator')->get();
        } else {
            $users = User::where('id', Auth::id())->get();
        }

        // dd($users->toArray());
        return view('home', compact('users'));
    }
}
