<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Pegawai;
use App\Absen;
use App\Status_absen;
use Yajra\Datatables\Html\Builder; 
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\TugasPegawai;
use App\Pengumpulan;
use Session;
use Excel;

class HrdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        //
        if ($request->ajax()) {
            $status_absens = Status_absen::with('absen');
            return Datatables::of($status_absens)
                ->addColumn('action', function($status_absen){
                    return view('datatables._edit', [
                        'model' => $status_absen,
                        'edit_url' => route('rekapitulasi-absensi.edit', $status_absen->id),
                    ]);
                 })
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
        ->addColumn(['data'=>'absen.NIP', 'name'=>'absen.NIP', 'title'=>'NIP'])
        ->addColumn(['data'=>'absen.tanggal', 'name'=>'absen.tanggal', 'title'=>'Tanggal'])
        ->addColumn(['data'=> 'absen.jamMasuk', 'name'=>'absen.jamMasuk', 'title'=>'Jam Masuk'])
        ->addColumn(['data'=> 'absen.jamKeluar', 'name'=>'absen.jamKeluar', 'title'=>'Jam Keluar'])
        ->addColumn(['data'=> 'statusKehadiran', 'name'=>'statusKehadiran', 'title'=>'Status Kehadiran'])
        ->addColumn(['data'=> 'keterangan', 'name'=>'keterangan', 'title'=>'Keterangan'])
        ->addColumn(['data'=>'action', 'name'=>'name', 'orderable'=>false, 'searchable'=>false, 'title'=>'']);
        
        return view('hrd.index')->with(compact(
            'html',
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
       return view('hrd.create')->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
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
        
        $id = $request->input('pegawai_id');
        $pegawai = Pegawai::find($id);
        $masuk = $request->input('time_masuk');
        $keluar = $request->input('time_keluar');

        if ($request->input('status_id') == 'Tidak Hadir') {
            $masuk = $request->merge(['time_masuk' => null]);
            $keluar = $request->merge(['time_keluar' => null]);
        }

        $absen = new Absen;
        $absen->NIP = $pegawai->nik;
        $dt = Carbon::now();
        $absen->tanggal = $dt->toDateString();
        $absen->jamMasuk = $masuk;
        $absen->jamKeluar = $keluar;
        $absen->save();

        $statusAbsen = new Status_absen;
        $statusAbsen->absen_id = $id;
        
        $absen->status_absens()->saveMany([
            new Status_absen([
                'NIP' => $pegawai->nik,
                'tanggal' => $dt->toDateString(),
                'statusKehadiran' => $request->input('status_id'),
                'absen_id' => $id
            ]),
        ]);

        Session::flash('flash_notification', [
            "level" => "success",
            "message" => "Berhasil menyimpan Absensi baru"
        ]);

        return redirect()->route('rekapitulasi-absensi.index')->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
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
        $st_absen=Status_absen::find($id);
        return view('hrd.edit')->with(compact(
            'st_absen',
            'absenId',
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
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
        $st_absen = Status_absen::findOrFail($id);
        $this->validate($request, ['keterangan' => 'required | not_in']);
        $st_absen->update($request->only('keterangan'));
        Session::flash('flash_notification', [
            "level" => "success",
            "message" => "Berhasil menyimpan keterangan absen baru"
        ]);

        return redirect()->route('rekapitulasi-absensi.index')->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
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

    public function tugasHrd() {
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
        return view('hrd/tugashrd', ['tugass' => $tugas, 'jumlah' => $jumlah])->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }
    public function detailTugasHrd($id) {
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
        return view('hrd/detailtugashrd',['details' => $details])->with(compact(
            'imageName',
            'namaPegawai',
            'nikPegawai'
        ));
    }
    public function kumpulkanTugasHrd(Request $req) {
        $pengumpulan = New Pengumpulan;
        $tugas = TugasPegawai::find($req->id_tugas);
        if($req->hasFile('filekumpul')){
            $this -> validate($req ,[
                'filekumpul'=> 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:5000',
            ]);
            $asik = Input::file('filekumpul')->getClientOriginalName();
            // dd($asik);
            $fileLoc = $req->file('filekumpul')->move("bahan/hrd/".date('d-m-Y')."/", md5(time())."-".$asik);
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
            "message" => "Berhasil menyimpan Absensi baru"
        ]);
        return redirect()->action('HrdController@tugasHrd');
    }

    public function exportPost() {
        $status_absens = Status_absen::with('absen')
        ->orderBy('NIP')
        ->get();
        $date = Carbon::now();
        $lastMonth = $date->subMonth()->format('F');
        $year = $date->year;

        Excel::create('Rekapitulasi Absen Pegawai', 
        function($excel) use ($status_absens) {
            $date = Carbon::now();
            $lastMonth = $date->subMonth()->format('F');
            $year = $date->year;
            if ($date->month == 1) {
                $year = 2017;
            }
            $excel
                ->setTitle('Rekapitulasi Absen Pegawai')
                ->setCreator(Auth::user()->nama);

            $excel
                ->sheet($lastMonth.' '.$year, function($sheet) use ($status_absens) {
                    $date = Carbon::now();
                    $lastMonth = $date->subMonth()->format('F');
                    $year = $date->year;
                    $row = 1;
                    $sheet->row($row, [
                        'NIP',
                        'Tanggal',
                        'Jam Masuk',
                        'Jam Keluar',
                        'Status Kehadiran',
                        'Keterangan'
                    ]);
                    foreach ($status_absens as $status_absen) {
                        $sheet->row(++$row, [
                            $status_absen->absen->NIP,
                            $status_absen->absen->tanggal,
                            $status_absen->absen->jamMasuk,
                            $status_absen->absen->jamKeluar,
                            $status_absen->statusKehadiran,
                            $status_absen->keterangan
                        ]);
                    }
                });
        })->export('xls');
    }
}
