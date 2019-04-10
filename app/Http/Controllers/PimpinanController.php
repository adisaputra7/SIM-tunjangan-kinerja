<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Pegawai;
use App\SKP;
use App\Tunjangan_skp;
use Yajra\Datatables\Html\Builder; 
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Excel;
use Auth;


class PimpinanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        //
        $date = Carbon::now();
        $lastMonth = $date->subMonth()->format('F');
        if ($request->ajax()) {
            $pegawais = Pegawai::with('skp');
            return Datatables::of($pegawais)
                ->addColumn('action', function($pegawai){
                    return view('datatables._edit', [
                        'model' => $pegawai,
                        'edit_url' => route('pemberian-skp.edit', $pegawai->id),
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
            ->addColumn(['data'=>'nama', 'name'=>'nama', 'title'=>'Nama'])
            ->addColumn(['data'=>'nik', 'name'=>'nik', 'title'=>'NIP'])
            ->addColumn(['data'=>'divisi', 'name'=>'divisi', 'title'=>'Divisi'])
            ->addColumn(['data'=>'skp.nilai_skp', 'name'=>'skp.nilai_skp', 'title'=>'Nilai SKP'])
            ->addColumn(['data'=> 'skp.updated_at', 'name'=>'skp.updated_at', 'title'=>'Tanggal Pemberian SKP'])
            ->addColumn(['data'=>'action', 'name'=>'name', 'orderable'=>false, 'searchable'=>false, 'title'=>'']);
        return view('pimpinan.index')->with(compact(
            'html',
            'lastMonth',
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
        $pegawai = Pegawai::find($id);
        return view('pimpinan.edit')->with(compact(
            'pegawai',
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
        //
        $skp = SKP::findOrFail($id);
        // dd($request->all());
        // $skp->nilaiSKP = $request['nilaiSKP'];
        // $skp->save();
        $this->validate($request, ['nilai_skp' => 'required | numeric | min: 0| max: 100']);
        $skp->update($request->only('nilai_skp'));

        // dd($skp);
        $potonganSKP = new Tunjangan_skp;
        $potonganSKP->skp_id = $id;
        $nilai_skp = $request->input('nilai_skp');

        // Rules
        if ($nilai_skp >= 85 && $nilai_skp <= 100) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>100, 'potongan'=>1.00]),
                // new Tunjangan_skp(['potongan'=>0.0]),
            ]);
        } else if ($nilai_skp >= 80 && $nilai_skp <= 84) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>95, 'potongan'=>0.05]),
            ]);
        } else if ($nilai_skp >= 76 && $nilai_skp <= 79) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>85, 'potongan'=>0.15]),
            ]);
        } else if ($nilai_skp >= 71 && $nilai_skp <= 75) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>75, 'potongan'=>0.25]),
            ]);
        } else if ($nilai_skp >= 66 && $nilai_skp <= 70) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>65, 'potongan'=>0.35]),
            ]);
        } else if ($nilai_skp >= 61 && $nilai_skp <= 65) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>60, 'potongan'=>0.40]),
            ]);
        } else if ($nilai_skp >= 56 && $nilai_skp <= 60) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>55, 'potongan'=>0.45]),
            ]);
        } else if ($nilai_skp >= 51 && $nilai_skp <= 55) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>50, 'potongan'=>0.50]),
            ]);
        } else if ($nilai_skp >= 46 && $nilai_skp <= 50) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>45, 'potongan'=>0.55]),
            ]);
        } else if ($nilai_skp >= 41 && $nilai_skp <= 45) {
            // $skp->tunjangan_skps()->nilai->save(40);
            // $skp->tunjangan_skps()->potongan->save(0.60);
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>40, 'potongan'=>0.60]),
            ]);
        } else if ($nilai_skp >= 36 && $nilai_skp <= 40) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>35, 'potongan'=>0.65]),
            ]);
        } else if ($nilai_skp >= 31 && $nilai_skp <= 35) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>30,'potongan'=>0.70]),
            ]);
        } else if ($nilai_skp >= 26 && $nilai_skp <= 30) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>25,'potongan'=>0.75]),
            ]);
        } else if ($nilai_skp >= 21 && $nilai_skp <= 25) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>20, 'potongan'=>0.80]),
            ]);
        } else if ($nilai_skp >= 16 && $nilai_skp <= 20) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>15, 'potongan'=>0.85]),
            ]);
        } else if ($nilai_skp >= 10 && $nilai_skp <= 15) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>10, 'potongan'=>0.90]),
            ]);
        } else if ($nilai_skp >= 5 && $nilai_skp <= 9) {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>5, 'potongan'=>0.95]),
            ]);
        } else {
            $skp->tunjangan_skps()->saveMany([
                new Tunjangan_skp(['nilai'=>0, 'potongan'=>0.00]),
            ]);
        }
        Session::flash('flash_notification', [
            "level" => "success",
            "message" => "Berhasil menyimpan SKP baru"
        ]);

        return redirect()->route('pemberian-skp.index');
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

    public function exportPost() {
        $pegawais = Pegawai::with('skp')->get();
        $date = Carbon::now();
        $lastMonth = $date->subMonth()->format('F');
        $year = $date->year;
        if ($date->month == 1) {
            $year = 2017;
        }
        Excel::create('Data Kinerja Pegawai Bulan '.$lastMonth.' '.$year, 
        function($excel) use ($pegawais) {
            $date = Carbon::now();
            $lastMonth = $date->subMonth()->format('F');
            $year = $date->year;
            if ($date->month == 1) {
                $year = 2017;
            }
            $excel
            ->setTitle('Data Kinerja Pegawai Bulan '.$lastMonth.' '.$year)
            ->setCreator(Auth::user()->nama);

            $excel
                ->sheet($lastMonth.' '.$year, function($sheet) use ($pegawais) {
                    $date = Carbon::now();
                    $lastMonth = $date->subMonth()->format('F');
                    $year = $date->year;
                    if ($date->month == 1) {
                        $year = 2017;
                    }
                    $row = 1;
                    $sheet->row($row, [
                        'Nama',
                        'NIP',
                        'Divisi',
                        'Nilai SKP',
                        'Tanggal Pemberian SKP'
                    ]);
                    foreach ($pegawais as $pegawai) {
                        $sheet->row(++$row, [
                            $pegawai->nama,
                            $pegawai->nik,
                            $pegawai->divisi,
                            $pegawai->skp->nilai_skp,
                            $pegawai->skp->updated_at,
                        ]);
                    }
                });
            })->export('xls');
    }
}
