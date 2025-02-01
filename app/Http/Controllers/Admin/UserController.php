<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserProgram;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="dropdown">
                        <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" id="dropdown-default-outline-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Aksi
                        </button>
                        <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-default-outline-primary" style="">';
                        $btn .= '<a class="dropdown-item" href="'. route('admin.user.riwayat', $row->id).'"><i class="si si-list me-1"></i>Riwayat Program</a>';
                        $btn .= '<a class="dropdown-item"href="javascript:void(0)" onclick="openModal('. $row->id.')"><i class="fa fa-lock me-1"></i>Reset Password</a>';
                        $btn .= '<a class="dropdown-item" href="'. route('admin.user.edit', $row->id).'"><i class="si si-note me-1"></i>Ubah</a>';
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="hapus('. $row->id.')"><i class="si si-trash me-1"></i>Hapus</a>';
                    $btn .= '</div></div>';
                    return $btn; 
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                })
                ->rawColumns(['action']) 
                ->make(true);
        }

        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.user.form',[
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nim' => 'required|unique:users,nim',
            'nama' => 'required|string',
            'email' => 'required|unique:users,email',
            'hp' => 'required',
        ];

        $pesan = [
            'nim.required' => 'NIM tidak boleh kosong',
            'nim.unique' => 'NIM Sudah Terdaftar!',
            'nama.required' => 'Nama Lengkap tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email Sudah Terdaftar!',
            'hp.required' => 'No HP tidak boleh kosong',
        ];


        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = new User();
                $data->nim = $request->nim;
                $data->nama = $request->nama;
                $data->email = $request->email;
                $data->hp = $request->hp;
                $data->password = Hash::make($request->password);
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                return response()->json([
                    'fail' => true,
                    'errors' => $e,
                    'pesan' => 'Error Menyimpan Data Mahasiswa',
                ]);
            }

            DB::commit();
            return redirect()->route('admin.user.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $data = DB::table("anggota_eskul as a")
        ->select('a.*', 'b.nis', 'b.nama', 'b.kelas', 'b.hp', 'b.email', 'b.jk', 'b.alamat', 'c.nama as ekskul')
        ->join("anggota as b", "b.id", "=", "a.anggota_id")
        ->join("ekskul as c", "c.id", "=", "a.ekskul_id")
        ->where('a.id', $id)
        ->first();

        return view('anggota.detail',[
            'data' => $data,
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        return view('admin.user.edit',[
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'nama' => 'required|string',
            'email' => 'required|unique:users,email,'.$id,
            'jk' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'hp' => 'required',
            'alamat' => 'required',
        ];

        $pesan = [
            'email.required' => 'Email Wajib Diisi!',
            'email.unique' => 'Email Sudah Terdaftar!',
            'nama.required' => 'Nama Lengkap Wajib Diisi!',
            'jk.required' => 'Jenis Kelamin Wajib Diisi!',
            'tmp_lahir.required' => 'Tempat Lahir Diisi!',
            'tgl_lahir.required' => 'Tanggal Lahir Diisi!',
            'hp.required' => 'No HP Wajib Diisi!',
            'alamat.required' => 'Alamat Wajib Diisi!',
        ];


        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{

                $data = User::where('id', $id)->first();
                $data->nama = $request->nama;
                $data->jk = $request->jk;
                $auth->tmp_lahir = $request->tmp_lahir;
                $auth->tgl_lahir = $request->tgl_lahir;
                $auth->instansi = $request->instansi;
                $auth->jabatan = $request->jabatan;
                $data->hp = $request->hp;
                $data->email = $request->email;
                $data->alamat = $request->alamat;
                $data->is_member = $request->is_member;
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                return response()->json([
                    'fail' => true,
                    'errors' => $e,
                    'pesan' => 'Error Menyimpan Data Anggota',
                ]);
            }

            DB::commit();
            return redirect()->route('admin.user.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{

            $data = User::where('id', $id)->first();
            $data->delete();

        }catch(\QueryException $e){
            DB::rollback();
            return response()->json([
                'fail' => true,
                'errors' => $e,
                'pesan' => 'Gagal Hapus Data!',
            ]);
        }

        DB::commit();
        return response()->json([
            'fail' => false,
            'pesan' => 'Berhasil Hapus Data!',
        ]);
    }

    
    public function password($id, Request $request)
    {
        $rules = [
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required',
        ];

        $pesan = [
            'password.required' => 'Password baru tidak boleh kosong',
            'password.same' => 'Password tidak sesuai',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{
            DB::beginTransaction();
            try{
                $data = User::where('id', $id)->first();
                $data->password = Hash::make($request->password);
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                return response()->json([
                    'fail' => true,
                    'pesan' => $e,
                ]);
            }

            DB::commit();
            return response()->json([
                'fail' => false,
            ]);
        }
    }

    public function json($id){

        $data = User::where('id', $id)->first();

        return response()->json($data);
    }

    
    public function riwayat($id, Request $request)
    {
        $data = User::where('id', $id)->first();
        $program = UserProgram::with('program')->where('user_id', $id)->get();

        return view('admin.user.riwayat',[
            'data' => $data,
            'riwayat' => $program
        ]);
    }
}
