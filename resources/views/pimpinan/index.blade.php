@extends('layouts.home')

@section('core')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Pimpinan</a>
        </li>
        <li class="breadcrumb-item active">Daftar Kinerja</li>
    </ol>
    <div class="alert alert-warning " role="alert">
        Nilai SKP Bulan: <span style="color:red;">{{ $lastMonth }}</span>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <p>Daftar Kinerja Pegawai</p>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        {!! Form::open(['url' => route('export.pimpinan.post'),
                        'method' => 'post', 'class' => 'form-horizontal']) !!}
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                Export
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            {!! $html->table(['class'=>'table table-striped']) !!}
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('scripts')
    {!! $html->scripts() !!}
@endsection