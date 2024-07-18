<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;

class HomeController extends Controller
{

    public function index(){
        $program = Program::latest()->limit(6)->get();

        return view('landing.home',[
            'program' => $program,
        ]);
    }

    public function about(){


        return view('landing.about');
    }
}
