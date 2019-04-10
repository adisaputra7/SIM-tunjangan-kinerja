@extends('layouts.home')
@section('core')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Tugas Pegawai</li>
    </ol>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada masalah.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if($jumlah == NULL)
        <div class="alert alert-success " role="alert">
            <i class="fa fa-info-circle" aria-hidden="true"></i> Belum ada tugas untuk saat ini.
        </div>
    @endif
    <div class="flexparent" style="width: 100%;
                                   box-sizing: border-box;
                                   display: flex;
                                   flex-wrap: wrap;
                                   justify-content: flex-start;">
  
    @foreach($tugass as $tugas)
        <div class="col-xl-3 col-sm-6 mb-3" style="display: inline-block;">
            <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    
                </div>
                <div class="mr-5">{{$tugas->judul}}</div>
                <div class="mr-5">Dateline: {{$tugas->dateline_tugas}}</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="/hrd/detail_tugas_hrd/{{$tugas->idTugas}}">
                <span class="float-left">Kumpulkan Tugas</span>
                <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                </span>
            </a>
            </div>
        </div>
    @endforeach
    </div>

@endsection