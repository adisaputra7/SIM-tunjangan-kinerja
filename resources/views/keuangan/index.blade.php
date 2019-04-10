@extends('layouts.home')

@section('core')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Keuangan / Tunjangan Kinerja</li>
    </ol>
    <div class="card card-default">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <p>Daftar Tunjangan Kinerja Karyawan</p>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        {!! Form::open(['url' => route('export.keuangan.post'),
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
            <!-- Tabel  -->
            {!! $html->table(['class'=>'table table-striped'])!!}
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('scripts')
    {!! $html->scripts() !!}
@endsection