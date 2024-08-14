<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use DataTables;
use Carbon\Carbon;
use App\Models\Program;
use App\Models\UserProgram;
use App\Models\Kategori;
use Storage;
use PDF;
class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jenis = $request->jenis;
        $skema = $request->skema;
        $nama = $request->nama;
        $lokasi = $request->lokasi;

        $data = Program::orderBy('id', 'DESC')
        ->when($jenis, function($q, $jenis){
            return $q->where('kategori_id', $jenis);
        })
        ->when($skema, function($q, $skema){
            return $q->where('skema', $skema);
        })
        ->paginate(9);

        $kategori = Kategori::select('id as value', 'nama as label')->orderBy('nama', 'ASC')->get()->toArray();


        return view('landing.program.index',[
            'data' => $data,
            'kategori' => $kategori
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = auth()->guard('web')->user();
        $data = Program::where('slug', $slug)->first();
        if($user){
            $register = UserProgram::where('user_id', $user->id)
            ->where('program_id', $data->id)->first();
        }else{
            $register = null;
        }

        return view('landing.program.show', [
            'data' => $data,
            'register' => $register
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // dd($request->all());
        $rules = [
            'cv' => 'required',
            'ktp' => 'required',
            'transkrip' => 'required',
            'asuransi' => 'required',
        ];

        $pesan = [
            'cv.required' => 'CV wajib diisi',
            'ktp.required' => 'KTP wajib diisi',
            'transkrip.required' => 'Transkrip nilai terakhir wajib diisi',
            'asuransi.required' => 'Asuransi kesehatan wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $user = auth()->guard('web')->user();
                $program = Program::where('id', $request->program_id)->first();

                $data = new UserProgram();
                $data->kode = $this->getNumber();
                $data->user_id = $user->id;
                $data->program_id = $request->program_id;
                if($request->file('cv')){
                    $fileName = time() . '.' . $request->cv->extension();
                    Storage::disk('public')->putFileAs('uploads/daftar', $request->cv, $fileName);
                    $data->cv = '/uploads/daftar/'.$fileName;
                }
                if($request->file('ktp')){
                    $fileName = time() . '.' . $request->ktp->extension();
                    Storage::disk('public')->putFileAs('uploads/daftar', $request->ktp, $fileName);
                    $data->ktp = '/uploads/daftar/'.$fileName;
                }
                if($request->file('transkrip')){
                    $fileName = time() . '.' . $request->transkrip->extension();
                    Storage::disk('public')->putFileAs('uploads/daftar', $request->transkrip, $fileName);
                    $data->transkrip = '/uploads/daftar/'.$fileName;
                }
                if($request->file('asuransi')){
                    $fileName = time() . '.' . $request->asuransi->extension();
                    Storage::disk('public')->putFileAs('uploads/daftar', $request->asuransi, $fileName);
                    $data->asuransi = '/uploads/daftar/'.$fileName;
                }
                $data->status = 'pending';
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                return back()->withInput()->withErrors($e);
            }

            DB::commit();
            return redirect()->route('user.program');
        }
    }
    
    
    private function getNumber()
    {
        $q = UserProgram::select(DB::raw('MAX(RIGHT(kode,5)) AS kd_max'));

        $code = 'DFT/';
        $no = 1;
        date_default_timezone_set('Asia/Jakarta');

        if($q->count() > 0){
            foreach($q->get() as $k){
                return $code . date('ym') .'/'.sprintf("%05s", abs(((int)$k->kd_max) + 1));
            }
        }else{
            return $code . date('ym') .'/'. sprintf("%05s", $no);
        }
    }

    public function user(Request $request)
    {
        $user = auth()->guard('web')->user();

        $data = UserProgram::where('user_id', $user->id)->orderBy('id', "DESc")->get();
        // $user = User::orderBy('nama', 'ASC')->get();

        return view('landing.program.user',[
            'data' => $data,
            // 'user' => $user
        ]);
    }

    public function userShow($id, Request $request)
    {
        $user = auth()->guard('web')->user();

        $data = UserProgram::where('id', $id)->first();

        return view('landing.program.user_show',[
            'data' => $data,
        ]);
    }
}
