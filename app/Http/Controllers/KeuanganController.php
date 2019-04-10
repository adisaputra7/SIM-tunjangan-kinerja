<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Pegawai;
use App\Absen;
use App\Status_absen;
use App\Tunjangan_skp;
use App\Grade;
use Yajra\Datatables\Html\Builder; 
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\TugasPegawai;
use App\Pengumpulan;
use Illuminate\Http\Request;
use Excel;
use Session;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        // Iterasi Kehadiran
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
        //dd($coba, $batasatas,$batasatas, $daysForExtraCoding);

        $pegawais = Pegawai::with('grade')
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

        // Iterasi Kedua
        $potonganSkpArray= array();
        $pegawaiSkp = array();
        $pegawaiGrade = array();
        // Iterasi Kedua
        foreach($pegawais as $pegawai){
            $potonganSkp = Tunjangan_skp::with('skp')->where('skp_id', $pegawai->skp_id)->orderBy('id','desc')->first();
            $grade = Grade::find($pegawai->grade_id);
            $potonganSkpArray[$pegawai->skp_id] = $potonganSkp->potongan;  
            $pegawaiSkp[$pegawai->skp_id] = $pegawai->nama;
            $pegawaiGrade[$pegawai->skp_id] = $grade->tunjangan;

            $potonganSkpFinal[$pegawai->skp_id] = $potonganSkpArray[$pegawai->skp_id] * 0.3 * $pegawaiGrade[$pegawai->skp_id]; 
            $potonganSkpAkhir[$pegawai->nik]=$potonganSkpFinal[$pegawai->skp_id];
        }
         
       
        // Iterasi Ketiga
        $index = 0;
        $performaArr = 0;
        $performa=array();
        foreach($pegawais as $key => $pegawai) {
            if (sizeof($coba) == 0) {
                break;
            } else {
                if($pegawai->nik == $coba[$index]->NIP) {
                    $performaArr = $pegawai->grade->tunjangan * 0.3 * $coba[$index]->hadir/$daysForExtraCoding;
                    $hasilPerforma=(int)$performaArr;
                    $performa[$pegawai->nik]=$hasilPerforma;
                    $index++;
                }
            }
        }
        //dd($coba, $daysForExtraCoding, $kehadiranArr, $potonganSkpAkhir, $performa);
        //dd($pegawais[2]->grade->tunjangan * 0.3 * $coba[0]->hadir/$daysForExtraCoding);
        //dd($performa);
        //iterasi Total
        $index = 0;
        $totalPotongan =array();
        $totalTunjangan =array();
        $totalTunjangan = array_fill(0, 0, 0);
        foreach($pegawais as $pegawai) {
            if (sizeof($coba) == 0) {
                break;
            } else {
                if($pegawai->nik == $coba[$index]->NIP) {
                    $totalPotongan[$pegawai->nik] = $potonganHadir[$pegawai->nik]+$potonganSkpFinal[$pegawai->skp_id]+$performa[$pegawai->nik];
                    $totalTunjangan[$pegawai->nik] = $pegawaiGrade[$pegawai->skp_id]-$totalPotongan[$pegawai->nik];
                    $pegawai->potongan = $totalPotongan[$pegawai->nik];
                    $pegawai->tunjangan = $totalTunjangan[$pegawai->nik];
                    $pegawai->save();
                    $index++;
                }
            }
            
            $totalPotongan[$pegawai->nik] = 0;
            $totalTunjangan[$pegawai->nik] = 0;
        }

        $index = 0;
        //Datatable
        if ($request->ajax()) {
            return Datatables::of($pegawais)
                ->orderColumn('nama','divisi $1')
                ->make(true);
        }
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
        $html = $htmlBuilder
            ->addColumn(['data'=>'nama', 'name'=>'nama', 'title'=>'Nama'])
            ->addColumn(['data'=>'nik', 'name'=>'nik', 'title'=>'NIP'])
            ->addColumn(['data'=>'divisi', 'name'=>'divisi', 'title'=>'Divisi'])
            ->addColumn(['data'=>'potongan', 'name'=>'potongan', 'title'=>'Potongan'])
            ->addColumn(['data'=>'tunjangan', 'name'=>'tunjangan', 'title'=>'Tunjangan'])
            ->addColumn(['data'=>'updated_at', 'name'=>'updated_at', 'title'=>'Waktu Update']);

        return view('keuangan.index')->with(compact('html', 'imageName', 'namaPegawai', 'nikPegawai'));
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

    public function tugasKeuangan() {
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
        return view('keuangan/tugaskeuangan', ['tugass' => $tugas, 'jumlah' => $jumlah])->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }
    public function detailTugasKeuangan($id) {
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
        return view('keuangan/detailtugaskeuangan',['details' => $details])->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }
    public function kumpulkanTugasKeuangan(Request $req) {
        $pengumpulan = New Pengumpulan;
        $tugas = TugasPegawai::find($req->id_tugas);
        if($req->hasFile('filekumpul')){
            $this -> validate($req ,[
                'filekumpul'=> 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:5000',
            ]);
            $asik = Input::file('filekumpul')->getClientOriginalName();
            // dd($asik);
            $fileLoc = $req->file('filekumpul')->move("bahan/keuangan/".date('d-m-Y')."/", md5(time())."-".$asik);
            // dd($fileLoc); 
            $pengumpulan->idTugas = $req->id_tugas;
            $pengumpulan->pesan = $req->pesan;
            $pengumpulan->attachment = $fileLoc;
            $pengumpulan->save();
            $tugas->statusFinal = -1;
            $tugas->save();
            return redirect()->action('KeuanganController@tugasKeuangan');
        }
        else {
            $pengumpulan->idTugas = $req->id_tugas;
            $pengumpulan->pesan = $req->pesan;
            $pengumpulan->attachment = NULL;
            $pengumpulan->save();
            $tugas->statusFinal = -1;
            $tugas->save();
            return redirect()->action('KeuanganController@tugasKeuangan');
        }
        Session::flash('flash_notification', [
            "level" => "success",
            "message" => "Berhasil Mengumpulkan Tugas"
        ]);
        return redirect()->action('KeuanganController@tugasKeuangan');
    }

    public function exportPost() {
        $pegawais = Pegawai::with('grade')
        ->orderBy('nik')
        ->get();
        $date = Carbon::now();
        $lastMonth = $date->subMonth()->format('F');
        $year = $date->year;

        Excel::create('Data Tunjangan Pegawai Bulan '.$lastMonth.' '.$year, 
        function($excel) use ($pegawais) {
            $date = Carbon::now();
            $lastMonth = $date->subMonth()->format('F');
            $year = $date->year;
            if ($date->month == 1) {
                $year = 2017;
            }
            $excel
                ->setTitle('Data Tunjangan Pegawai Bulan '.$lastMonth.' '.$year)
                ->setCreator(Auth::user()->nama);

            $excel
                ->sheet($lastMonth.' '.$year, function($sheet) use ($pegawais) {
                    $date = Carbon::now();
                    $lastMonth = $date->subMonth()->format('F');
                    $year = $date->year;
                    $row = 1;
                    $sheet->row($row, [
                        'Nama',
                        'NIP',
                        'Divisi',
                        'Potongan',
                        'Tunjangan',
                        'Waktu Update'
                    ]);
                    foreach ($pegawais as $pegawai) {
                        $sheet->row(++$row, [
                            $pegawai->nama,
                            $pegawai->nik,
                            $pegawai->divisi,
                            'Rp '. number_format($pegawai->potongan),
                            'Rp '. number_format($pegawai->tunjangan),
                            $pegawai->updated_at
                        ]);
                    }
                });
        })->export('xls');
    }
}
