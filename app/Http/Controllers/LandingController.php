<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Booking;
class LandingController extends Controller
{

    public function index()
    {
        return view('landing.home');
    }
    
    public function about(Request $request)
    {
        return view('landing.about');
    }
}
