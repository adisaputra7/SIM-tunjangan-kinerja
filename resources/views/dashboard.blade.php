@extends('layouts.home')

@section('core')
    <!-- Breadcrumbs--> 
    <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">My Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                    <i class="fa fa-fw fa-money "></i>
                    </div>
                    <div class="mr-5">Tunjangan Anda Bulan {{ $lastMonth }}:</div>
                    <p>Rp. {{ number_format($pegawaiAuthTunjangan) . "\n" }}</p>
                </div>
            </div>
        </div>
    @role('pimpinan')
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                    <i class="fa fa-fw fa-line-chart"></i>
                    </div>
                    <div class="mr-5">Rata-Rata Nilai SKP:</div>
                    <p>{{ number_format($meanSkp) . "\n" }}</p>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ url('/pimpinan/pemberian-skp') }}">
                    <span class="float-left"> Details</span>
                    <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                    </span>
                </a>
            </div>
        </div>
    @endrole
    @role('keuangan')
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                <i class="fa fa-fw fa-usd"></i>
                </div>
                <div class="mr-5">Total Tunjangan</div>
                <p>Rp. {{ number_format($tunjanganTotal) . "\n" }}</p>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ url('/keuangan/tunjangan') }}">
                <span class="float-left"> Details</span>
                <span class="float-right">
                <i class="fa fa-angle-right"></i>
                </span>
            </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Rata-Rata Potongan</div>
                <p>Rp. {{ number_format($meanPotongan) . "\n" }}</p>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ url('/keuangan/tunjangan') }}">
                <span class="float-left">
                    View Details
                </span>
                <span class="float-right">
                <i class="fa fa-angle-right"></i>
                </span>
            </a>
            </div>
        </div>
    @endrole
    @role('supervisi')
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Jumlah Tugas Selesai:</div>
                <p>{{ $pegawaiTugasSatu . "\n" }}</p>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ url('/daftar_tugas') }}">
                <span class="float-left">
                    View Details
                </span>
                <span class="float-right">
                <i class="fa fa-angle-right"></i>
                </span>
            </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Jumlah Tugas Belum Dikonfirmasi:</div>
                <p>{{ $pegawaiTugasMinusSatu . "\n" }}</p>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ url('/pengumpulan') }}">
                <span class="float-left">
                    View Details
                </span>
                <span class="float-right">
                <i class="fa fa-angle-right"></i>
                </span>
            </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Jumlah Tugas Belum Selesai:</div>
                <p>{{ $pegawaiTugasNol . "\n" }}</p>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ url('/daftar_tugas') }}">
                <span class="float-left">
                    View Details
                </span>
                <span class="float-right">
                <i class="fa fa-angle-right"></i>
                </span>
            </a>
            </div>
        </div>
    @endrole 
    </div>
@endsection