<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Pegawai;
use App\Pengumpulan;
use App\TugasPegawai;
use Session;

class SupervisiController extends Controller
{
    public function getAllPegawai() {
        $pegawaiGet = Pegawai::where('id','=', Auth::user()->id )->get();
        foreach($pegawaiGet as $pegawai) {
            $namaPegawai= $pegawai->nama;
            $nikPegawai = $pegawai->nik;
            if ($pegawai->foto == null) {
                $imageName = 'images/photo-profile.png';
            } else {
                $imageName = 'images/'.$pegawai->foto;
            }
        }

        $pegawai = Pegawai::where('id','!=','2')->where('id','!=','4')->get();
        // dd($pegawai);
        return view('supervisi/beritugas', ['pegawais' => $pegawai])->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }
    public function getAllTugas() {
        $pegawais = Pegawai::where('id','=', Auth::user()->id )->get();
        foreach($pegawais as $pegawai) {
            $namaPegawai= $pegawai->nama;
            $nikPegawai = $pegawai->nik;
            if ($pegawai->foto == null) {
                $imageName = 'images/photo-profile.png';
            } else {
                $imageName = 'images/'.$pegawai->foto;
            }
        }
        $tugas = TugasPegawai::orderBy('tanggal', 'asc')->get();
        return view('supervisi/semuatugas', ['tugass' => $tugas])->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));;
    }

    public function pengumpulanTugas() {
        $pegawais = Pegawai::where('id','=', Auth::user()->id )->get();
        foreach($pegawais as $pegawai) {
            $namaPegawai= $pegawai->nama;
            $nikPegawai = $pegawai->nik;
            if ($pegawai->foto == null) {
                $imageName = 'images/photo-profile.png';
            } else {
                $imageName = 'images/'.$pegawai->foto;
            }
        }
        $kumpul = Pengumpulan::all();
        $kumpul = $this->jointable();
        return view('supervisi/pengumpulan', ['kumpuls' => $kumpul])->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }

    public function konfirmasiTugas($id_tugas) {
        // $this->pengumpulanTugas($id_tugas);
        $tugas = TugasPegawai::find($id_tugas);
        $tugas->statusFinal = 1;
        $tugas->save();
        return redirect()->back();
    }

    public function addTugas(Request $req) {
        $this -> validate($req, [
            "judul_tugas" => 'required', 
            "penjelasan" => 'required',
            "tanggal_akhir" => 'required',
            "pegawai" => 'required'
        ]);
        $tugas = New TugasPegawai;
        $tugas->idPegawai = $req->pegawai;
        $tugas->judul = $req->judul_tugas;
        $tugas->tanggal = date('d-m-Y');
        $tugas->statusFinal = false;
        $tugas->penjelasan_tugas = $req->penjelasan;
        $tugas->dateline_tugas = $req->tanggal_akhir;
        $tugas -> save();
        Session::flash('flash_notification', [
            "level" => "success",
            "message" => "Berhasil Memberikan Tugas"
        ]);
        return redirect('/');
        // $id = Auth::id();
    }

    public function jointable() {
        $data = DB::table('tugas_pengumpulan')
        ->join('tugas_pegawai', 'tugas_pengumpulan.idTugas', '=', 'tugas_pegawai.idTugas')
        ->join('pegawais','tugas_pegawai.idPegawai', '=', 'pegawais.user_id')
        ->select('tugas_pengumpulan.*', 'pegawais.nama', 'tugas_pegawai.statusFinal')
        ->get();
        return $data;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
