<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\UserProgram;

use Carbon\Carbon;
class BerandaController extends Controller
{

    public function index(){
        $user = auth()->user();
        $ovr = Collect([
            'program' => Program::get()->count(),
            'user' => User::get()->count(),
        ]);

        $now = Carbon::today();
        $berlangsung = Program::withCount('user')->where('tgl_mulai', '>=', $now)->get();

        return view('admin.beranda',[
            'ovr' => $ovr,
            'berlangsung' => $berlangsung 
        ]);
    }
}
