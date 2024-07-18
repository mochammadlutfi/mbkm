<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Carbon\Carbon;
use App\Models\Program;
use App\Models\UserProgram;
use App\Models\Kategori;

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
        DB::beginTransaction();
        try{
            $user = auth()->guard('web')->user();
            $program = Program::where('id', $request->program_id)->first();

            $data = new UserProgram();
            $data->user_id = $user->id;
            $data->program_id = $request->program_id;
            $data->status = 'pending';
            $data->save();

        }catch(\QueryException $e){
            DB::rollback();
            return back()->withInput()->withErrors($e);
        }

        DB::commit();
        return redirect()->route('user.program');
    }
    
    
    public function user(Request $request)
    {
        if ($request->ajax()) {
            $user_id = auth()->guard('web')->user()->id;

            $query = UserProgram::with('program')->where('user_id', $user_id)->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="dropdown">
                        <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" id="dropdown-default-outline-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Aksi
                        </button>
                        <div class="dropdown-menu fs-sm" aria-labelledby="dropdown-default-outline-primary" style="">';
                    if($row->status == 'lunas'){
                        // $btn .= '<a class="dropdown-item" target="_blank" href="'. route('admin.training.peserta.certificate', ['id' => $id, 'user'=>$row->id]).'"><i class="si si-badge me-1"></i>Sertifikat</a>';
                    }
                        
                        // $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="hapus('. $row->id.')"><i class="si si-trash me-1"></i>Hapus</a>';
                    $btn .= '</div></div>';
                    // $btn = '<button type="button" class="btn btn-sm btn-danger" onclick="hapus('. $row->id.')"><i class="fa fa-trash me-1"></i>Hapus</button>';

                    return $btn; 
                })
                ->editColumn('created_at', function ($row) {
                    $tgl = Carbon::parse($row->created_at);

                    return $tgl->translatedFormat('d M Y');
                })
                ->editColumn('status', function ($row) {
                    if($row->status == 'pending'){
                        return '<span class="badge bg-warning">Pending</span>';
                    }else if($row->status == 'terima'){
                        return '<span class="badge bg-primary">Terima</span>';
                    }else if($row->status == 'tolak'){
                        return '<span class="badge bg-danger">Tolak</span>';
                    }else if($row->status == 'selesai'){
                        return '<span class="badge bg-success">Selesai</span>';
                    }
                })
                ->rawColumns(['action','status']) 
                ->make(true);
        }

        // $data = Program::where('id', $id)->first();
        // $user = User::orderBy('nama', 'ASC')->get();

        return view('landing.program.user',[
            // 'data' => $data,
            // 'user' => $user
        ]);
    }
}
