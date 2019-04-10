<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Pegawai;
use App\Grade;
use App\SKP;
use App\Absen;
use App\Status_absen;
use Auth;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $pegawais = Pegawai::where('nama', Auth::user()->nama)
            ->with('Grade')
            ->with('SKP')
            ->get();
        //dd($pegawais);
        foreach($pegawais as $pegawai) {
            $namaPegawai = $pegawai->nama;
            $nikPegawai = $pegawai->nik;
            $divisiPegawai = $pegawai->divisi;
            $gradesPegawai = $pegawai->Grade->tunjangan;
            $skpPegawai = $pegawai->SKP->nilai_skp;
            $potonganPegawai = $pegawai->potongan;
            $tunjanganPegawai = $pegawai->tunjangan;
        }

        if ($pegawai->foto == null) {
            $imageName = 'images/photo-profile.png';
        } else {
            $imageName = 'images/'.$pegawai->foto;
        }

        $mytime = Carbon::now();
        $bulansebelumnya = '';
        $tahunsebelumnya = '';
        $bulanini = (int)date("m", strtotime($mytime));
        $tahunini = (int)date("Y", strtotime($mytime));
        if(date("m", strtotime($mytime)) == '1') {
            $bulansebelumnya = 12;
            $tahunsebelumnya =  $tahunini - 1;
        } else {
            $bulansebelumnya = $bulanini - 1;
            $tahunsebelumnya = $tahunini;
        }
        $batasatas = Carbon::parse('01/'.$bulanini.'/'.$tahunini)->format('Y/d/m');
        $batasbawah = Carbon::parse('01/'.$bulansebelumnya.'/'.$tahunsebelumnya)->format('Y/d/m');
        $coba = Status_absen::select('NIP', \DB::raw('count(NIP) as hadir'))
        ->orderBy('NIP')
        ->groupBy('NIP')
        ->where('tanggal', '>', $batasbawah)
        ->where('tanggal', '<', $batasatas)
        ->where('statusKehadiran', '=', 'Hadir')
        ->get();
        $dt = Carbon::create($tahunsebelumnya, $bulansebelumnya, 1);
        $dt2 = Carbon::create($tahunini, $bulanini, 1);
        $daysForExtraCoding = $dt->diffInDaysFiltered(function(Carbon $date) {
            return !$date->isWeekend();
        }, $dt2);

        $pegawais = Pegawai::with('grade')
        ->where('nama', Auth::user()->nama)
        ->orderBy('nik')
        ->get();
        $index = 0;
        $kehadiranArr=array();
        $potonganHadir=array();
        foreach($pegawais as $pegawai) {
            if (sizeof($coba) == 0) {
                break;
            } else {
                if($pegawai->nik == $coba[$index]->NIP) {
                    $kehadiranTunjangan = $pegawai->grade->tunjangan * 0.4 * $coba[$index]->hadir/$daysForExtraCoding;
                    $hasilKehadiran=(int)$kehadiranTunjangan;
                    $potonganHadir[$pegawai->nik]=$hasilKehadiran;
                    $kehadiranArr[$pegawai->nik]=$coba[$index]->hadir/$daysForExtraCoding;
                    $index++;
                }
            }
        }
        $index = 0;

        foreach($coba as $data) {
            if ($data->NIP == $pegawais[0]->nik) {
                $kehadiranPresentase = $data->hadir/$daysForExtraCoding;
            }
        }
        return view('profile')->with(compact(
            'namaPegawai', 
            'nikPegawai', 
            'divisiPegawai',
            'potonganPegawai',
            'tunjanganPegawai',
            'gradesPegawai',
            'skpPegawai',
            'imageName',
            'kehadiranPresentase'
        ));
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
        //
        $pegawai = Pegawai::where('id', Auth::user()->id)->first();
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName);

        Session::flash('flash_notification', [
            "level" => "success",
            "message" => "Berhasil update foto profil baru"
        ]);
        
        $pegawai->foto = $imageName;
        $pegawai->save();
        return redirect()->route('profile.index');
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
