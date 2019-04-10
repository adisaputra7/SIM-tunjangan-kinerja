<?php

namespace App\Http\Controllers;

use Auth;
use App\Pegawai;
use App\SKP;
use App\TugasPegawai;
use Illuminate\Http\Request;
use Money\Currency;
use Money\Money;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $date = Carbon::now();
        $lastMonth = $date->subMonth()->format('F');
        $pegawaiAuthSkp = Pegawai::where('id','=', Auth::user()->id )->with('SKP')->get();
        
        foreach($pegawaiAuthSkp as $pegawai) {
            $pegawaiAuthTunjangan = $pegawai->tunjangan;
        }
        //$pegawaiAuthTunjangan = $pegawaiAuthSkp->tunjangan;

        //dd(Auth::user()->nama,Pegawai::where('id','=', Auth::user()->id )->get());
        $tunjangan = 0;
        $tempTunjangan = 0;
        $tunjanganTotal = 0;
        
        $potongan = 0;
        $tempPotongan = 0;
        $meanPotongan = 0;
        $potonganTotal = 0;

        $pegawais = Pegawai::where('id','=', Auth::user()->id )->get();
        $pegawaiAll = Pegawai::get();
        $jmlPegawai = $pegawaiAll->count();
        foreach($pegawais as $pegawai) {
            $namaPegawai= $pegawai->nama;
            $nikPegawai = $pegawai->nik;
            $tunjangan += $pegawai->tunjangan;
            $tempTunjangan = $tunjangan;
            $tunjanganTotal = $tempTunjangan;

            $potongan += $pegawai->potongan;
            $tempPotongan = $potongan;
            $potonganTotal = $tempPotongan;

            $meanPotongan = $potonganTotal/(float)$jmlPegawai;

            $tempPotongan = 0;
            $tempTunjangan = 0;

            if ($pegawai->foto == null) {
                $imageName = 'images/photo-profile.png';
            } else {
                $imageName = 'images/'.$pegawai->foto;
            }
        }
        $pegawaiSkp = Pegawai::with('SKP')->get();

        $tempSkp = 0;
        $skp = 0;
        $skpTotal = 0;
        $meanSkp = 0;
        foreach($pegawaiSkp as $pegawai) {
            $skp += $pegawai->SKP->nilai_skp;
            $tempSkp = $skp;
            $skpTotal = $tempSkp;

            $meanSkp = $skpTotal/(float)$jmlPegawai;
            $tempSkp = 0;
        }
        $pegawaiTugasSatu = TugasPegawai::where('statusFinal', 1)
        ->count();
        $pegawaiTugasMinusSatu = TugasPegawai::where('statusFinal', -1)
        ->count();
        $pegawaiTugasNol = TugasPegawai::where('statusFinal', 0)
        ->count();

        //dd($pegawaiTugasSatu, $pegawaiTugasMinusSatu,$pegawaiTugasNol );
        return view('dashboard')->with(compact(
            'tunjanganTotal', 
            'meanPotongan', 
            'meanSkp',
            'pegawaiAuthTunjangan',
            'lastMonth',
            'pegawaiTugasSatu',
            'pegawaiTugasMinusSatu',
            'pegawaiTugasNol',
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }
}
