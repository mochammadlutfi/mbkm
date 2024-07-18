<?php


namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Providers\RouteServiceProvider;
use Validate;
use Auth;
use Illuminate\Support\Facades\Route;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin()
    {
        return view('landing.auth.login');
    }

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function login(Request $request)
    {
    $input = $request->all();
    $rules = [
        'nim' => 'required|exists:users,nim',
        'password' => 'required|string'
    ];

    $pesan = [
        'nim.exists' => 'NIM tidak terdaftar',
        'nim.required' => 'NIM tidak boleh kosong',
        'password.required' => 'Password tidak boleh kosong',
    ];


    $validator = Validator::make($request->all(), $rules, $pesan);
    if ($validator->fails()){
        return back()->withInput()->withErrors($validator->errors());
    }else{
        if(auth()->guard('web')->attempt(array('nim' => $input['nim'], 'password' => $input['password']), true))
        {
            return redirect()->route('home');
        }else{
            $gagal['password'] = array('Password salah!');
            return back()->withInput()->withErrors($gagal);
        }
    }

    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('home');
    }

    
    public function showRegister()
    {
        return view('landing.auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'nim' => 'required|unique:users,nim',
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'hp' => 'required',
            'password' => 'required',
        ];

        $pesan = [
            'nim.required' => 'NIM tidak boleh kosong',
            'nim.unique' => 'NIM sudah terdaftar',
            'nama.required' => 'Nama Lengkap tidak boleh kosong',
            'email.required' => 'Alamat Email tidak boleh kosong',
            'email.unique' => 'Alamat Email sudah terdaftar',
            'hp.required' => 'No HP tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $auth = new User();
                $auth->nim = $request->nim;
                $auth->nama = $request->nama;
                $auth->email = $request->email;
                $auth->password = Hash::make($request->password);
                $auth->hp = $request->hp;
                $auth->save();

            }catch(\QueryException $e){
                DB::rollback();
                return back()->withInput()->withErrors($e);
            }

            DB::commit();
            auth()->guard('web')->attempt(array('email' => $request->email, 'password' => $request->password), true);
            return redirect()->route('home');
        }
    }
}
