<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Konversi;
use App\Models\UserProgram;
use App\Models\Matkul;
use App\Models\KonversiDetail;
use PDF;
class KonversiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Konversi::orderBy('id', 'DESC')->get();

        return view('admin.konversi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $daftar = UserProgram::where('status', 'terima')->select('id as value', 'kode as label')->get();
        $matkul = Matkul::latest()->get();
        return view('admin.konversi.create', compact('daftar', 'matkul'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'user_program_id' => 'required',
            'tgl' => 'required',
        ];

        $pesan = [
            'user_program_id.required' => 'No Pendaftaran Wajib Diisi!',
            'tgl.required' => 'Tanggal Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }else{
            DB::beginTransaction();
            try{
                $data = new Konversi();
                $data->user_program_id = $request->user_program_id;
                $data->tgl = $request->tgl;
                $data->save();

                if(count($request->lines)){
                    foreach($request->lines as $l){
                        $line = new KonversiDetail();
                        $line->mitra_matkul_id = $l['mitra_matkul_id'];
                        $line->mitra_nilai = $l['mitra_nilai'];
                        $line->matkul_id = $l['matkul_id'];
                        $line->nilai = $l['nilai'];

                        $data->detail()->save($line);
                    }
                }

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
        $data = Konversi::where('id', $id)->first();

        return view('admin.konversi.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        $data = Konversi::where('id', $id)->first();

        $config = [
            'format' => 'A4-P', // Landscape
            'padding' => '10px'
        ];
        // $stylesheet = file_get_contents(base_path('/resources/css/certificate.css'));

        $pdf = PDF::loadView('pdf.konversi', [
            'data' => $data
        ], [ ], $config);

        return $pdf->stream('Konversi Nilai '. $data->daftar->kode.'.pdf');
    }
}
