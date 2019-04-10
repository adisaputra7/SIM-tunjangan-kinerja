<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Pegawai;
use App\TugasPegawai;
use App\Pengumpulan;
use Session;

class PegawaiController extends Controller
{
    public function tugasPegawai() {
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
        $tugas = TugasPegawai::where('statusFinal', 0)->where('idPegawai', Auth::user()->id)->get();
        // dd($tugas);
        $jumlah = $tugas->count();
        return view('pegawai/tugaspegawai', ['tugass' => $tugas, 'jumlah' => $jumlah])->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));;
    }
    public function detailTugasPegawai($id) {
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
        $details = TugasPegawai::find($id);
        // dd($tugas);
        return view('pegawai/detailtugas',['details' => $details])->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }
    public function kumpulkanTugasPegawai(Request $req) {
        $pengumpulan = New Pengumpulan;
        $tugas = TugasPegawai::find($req->id_tugas);
        if($req->hasFile('filekumpul')){
            $this -> validate($req ,[
                'filekumpul'=> 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:5000',
            ]);
            $asik = Input::file('filekumpul')->getClientOriginalName();
            // dd($asik);
            $fileLoc = $req->file('filekumpul')->move("bahan/pegawai/".date('d-m-Y')."/", md5(time())."-".$asik);
            // dd($fileLoc);
            $pengumpulan->idTugas = $req->id_tugas;
            $pengumpulan->pesan = $req->pesan; 
            $pengumpulan->attachment = $fileLoc;
            $pengumpulan->save();
            $tugas->statusFinal = -1;
            $tugas->save();
        }
        else{
            $pengumpulan->idTugas = $req->id_tugas;
            $pengumpulan->pesan = $req->pesan;
            $pengumpulan->attachment = NULL;
            $pengumpulan->save();
            $tugas->statusFinal = -1;
            $tugas->save();
        }
        Session::flash('flash_notification', [
            "level" => "success",
            "message" => "Berhasil Mengumpulkan Tugas"
        ]);
        return redirect()->action('PegawaiController@tugasPegawai');
    }
}
