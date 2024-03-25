<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrcodeCheck;

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
        $checkings = QrcodeCheck::where('student_id',auth()->user()->id)->get();
        return view('home',compact('checkings'));
    }
}
