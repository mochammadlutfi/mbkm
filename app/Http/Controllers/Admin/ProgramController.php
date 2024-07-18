<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Storage;
use Carbon\Carbon;
use App\Models\Program;
use App\Models\UserProgram;
use App\Models\User;
use App\Models\Kategori;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Program::with('kategori')->withCount('user')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="dropdown">
                        <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" id="dropdown-default-outline-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Aksi
                        </button>
                        <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-default-outline-primary" style="">';
                        $btn .= '<a class="dropdown-item" href="'. route('admin.program.peserta', $row->id).'"><i class="si si-users me-1"></i>Data Peserta</a>';
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit('. $row->id.', `'.$row->status.'`)"><i class="si si-note me-1"></i>Ubah Status</a>';
                        $btn .= '<a class="dropdown-item" href="'. route('admin.program.edit', $row->id).'"><i class="si si-note me-1"></i>Ubah</a>';
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="hapus('. $row->id.')"><i class="si si-trash me-1"></i>Hapus</a>';
                    $btn .= '</div></div>';
                    return $btn; 
                })
                ->addColumn('judul', function ($row) {
                    $val = '<div class="fw-semibold">'. $row->nama .'</div>';
                    $val .= '<div class="fs-sm">'. $row->kategori->nama .'</div>';

                    return $val;
                })
                ->editColumn('pelaksanaan', function ($row) {
                    $tgl_mulai = Carbon::parse($row->tgl_mulai);
                    $tgl_selesai = Carbon::parse($row->tgl_selesai);
                    if($tgl_mulai->eq($tgl_selesai) || $row->tgl_selesai == null){
                        return $tgl_mulai->translatedformat('d M Y');
                    }else{
                        return $tgl_mulai->translatedformat('d') . ' - '. $tgl_selesai->translatedformat('d M Y');
                    }
                })
                ->editColumn('status', function ($row) {
                    if($row->status == 'draft'){
                        return '<span class="badge bg-warning">Draft</span>';
                    }else if($row->status == 'buka'){
                        return '<span class="badge bg-primary">Buka</span>';
                    }else{
                        return '<span class="badge bg-danger">Tutup</span>';
                    }
                })
                ->rawColumns(['action', 'status', 'judul']) 
                ->make(true);
        }
        return view('admin.program.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::select('id as value', 'nama as label')->orderBy('nama', 'ASC')->get()->toArray();

        return view('admin.program.create',[
            'kategori' => $kategori
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
            'nama' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tgl_daftar' => 'required',
            // 'tgl_pelaksanaan' => 'required',
            'kuota' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama Wajib Diisi!',
            'deskripsi.required' => 'Deskripsi Wajib Diisi!',
            'lokasi.required' => 'Lokasi Wajib Diisi!',
            'tgl_daftar.required' => 'Tanggal Pendaftaran Wajib Diisi!',
            'tgl_pelaksanaan.required' => 'Tanggal Training Wajib Diisi!',
            'kuota.required' => 'Kuota Peserta Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $tgl_daftar = explode(" - ",$request->tgl_daftar);
                $tgl_pelaksanaan = explode(" - ",$request->tgl_pelaksanaan);

                $data = new Program();
                $data->nama = $request->nama;
                $data->skema = $request->skema;
                $data->kategori_id = $request->kategori_id;
                $data->lokasi = $request->lokasi;
                $data->mitra = $request->mitra;
                $data->deskripsi = $request->deskripsi;
                $data->tgl_mulai_daftar = $tgl_daftar[0];
                $data->tgl_selesai_daftar = (count($tgl_daftar) > 1) ? $tgl_daftar[1] : null;
                $data->tgl_mulai =  (count($tgl_pelaksanaan) > 1) ? $tgl_pelaksanaan[0] : null;
                $data->tgl_selesai = (count($tgl_pelaksanaan) > 1) ? $tgl_pelaksanaan[1] : null;
                $data->kuota = $request->kuota;
                $data->status = $request->status;
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->route('admin.program.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Program::where('id', $id)->first();

        $data->tgl_daftar = $data->tgl_mulai_daftar .' - '. $data->tgl_selesai_daftar;
        $data->tgl_training = $data->tgl_mulai .' - '. $data->tgl_selesai;

        return view('admin.program.edit',[
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
            'nama' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tgl_daftar' => 'required',
            'tgl_training' => 'required',
            'kuota' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama Wajib Diisi!',
            'deskripsi.required' => 'Deskripsi Wajib Diisi!',
            'lokasi.required' => 'Lokasi Wajib Diisi!',
            'tgl_daftar.required' => 'Tanggal Pendaftaran Wajib Diisi!',
            'tgl_training.required' => 'Tanggal Training Wajib Diisi!',
            'kuota.required' => 'Kuota Peserta Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $tgl_daftar = explode(" - ",$request->tgl_daftar);
                $tgl_training = explode(" - ",$request->tgl_training);
                
                $data = Training::where('id', $id)->first();
                $data->nama = $request->nama;
                $data->jenis = $request->jenis;
                $data->lokasi = $request->lokasi;
                $data->deskripsi = $request->deskripsi;
                $data->tgl_mulai_daftar = $tgl_daftar[0];
                $data->tgl_selesai_daftar = (count($tgl_daftar) > 1) ? $tgl_daftar[1] : null;
                $data->tgl_mulai = $tgl_training[0];
                $data->tgl_selesai = (count($tgl_training) > 1) ? $tgl_training[1] : null;
                $data->kuota = $request->kuota;
                $data->status = $request->status;
                $data->waktu_mulai = $request->waktu_mulai;
                $data->waktu_selesai = $request->waktu_selesai;
                $data->harga = isset($request->harga) ? $request->harga : 0;
                
                if($request->foto){
                    $fileName = time() . '.' . $request->foto->extension();
                    Storage::disk('public')->putFileAs('uploads/training', $request->foto, $fileName);
                    $data->foto = '/uploads/training/'.$fileName;
                }
               
                if($request->hasfile('document')){
                    $fileName = time() . '.' . $request->document->extension();
                    Storage::disk('public')->putFileAs('uploads/training', $request->document, $fileName);
                    $data->document = '/uploads/training/'.$fileName;
                }
                $data->save();

            }catch(\QueryException $e){
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->route('admin.program.index');
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

            $data = Training::where('id', $id)->first();
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

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $rules = [
            'status' => 'required',
        ];

        $pesan = [
            'status.required' => 'Status Wajib Diisi!',
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
                $data = Training::where('id', $request->id)->first();
                $data->status = $request->status;
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

    
    public function peserta($id, Request $request)
    {
        if ($request->ajax()) {
            $query = UserProgram::with('user')->where('training_id', $id)->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="dropdown">
                        <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" id="dropdown-default-outline-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Aksi
                        </button>
                        <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-default-outline-primary" style="">';
                        $btn .= '<a class="dropdown-item" href="'. route('admin.program.edit', $row->id).'"><i class="si si-note me-1"></i>Ubah</a>';
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="hapus('. $row->id.')"><i class="si si-trash me-1"></i>Hapus</a>';
                    $btn .= '</div></div>';
                    return $btn; 
                })
                ->editColumn('tgl_training', function ($row) {
                    $tgl_mulai = Carbon::parse($row->tgl_mulai);
                    $tgl_selesai = Carbon::parse($row->tgl_selesai);
                    if($tgl_mulai->eq($tgl_selesai) || $row->tgl_selesai == null){
                        return $tgl_mulai->translatedformat('d M Y');
                    }else{
                        return $tgl_mulai->translatedformat('d') . ' - '. $tgl_selesai->translatedformat('d M Y');
                    }
                })
                ->editColumn('tgl_daftar', function ($row) {
                    $tgl_mulai = Carbon::parse($row->tgl_mulai_daftar);
                    $tgl_selesai = Carbon::parse($row->tgl_selesai_daftar);
                    if($tgl_mulai->eq($tgl_selesai) || $row->tgl_selesai_daftar == null){
                        return $tgl_mulai->translatedformat('d M Y');
                    }else{
                        return $tgl_mulai->translatedformat('d M') . ' - '. $tgl_selesai->translatedformat('d M Y');
                    }
                })
                ->rawColumns(['action',]) 
                ->make(true);
        }

        $data = Training::where('id', $id)->first();
        $user = User::orderBy('nama', 'ASC')->get();

        return view('admin.program.peserta',[
            'data' => $data,
            'user' => $user
        ]);
    }
}
