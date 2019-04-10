@extends('layouts.home')

@section('core')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">HRD</a>
        </li>
        <li class="breadcrumb-item active"><a href="{{ url('hrd/rekapitulasi-absensi') }}">Daftar SKP</a></li>
        <li class="breadcrumb-item active">Ubah Status Absen</li>
    </ol>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">Ubah Status Absen</div>
                <div class="card-body">
                    {!! Form::model($st_absen, ['url'=>route('rekapitulasi-absensi.update', $st_absen->id), 
                    'method'=>'PUT']) !!}
                        <div class="form-group {{$errors->has('nik') ? 'has-error' : '' }}">
                            {!! Form::label('nik', 'NIK Pegawai') !!}
                            {!! Form::text('nik', $st_absen->NIP ,['class'=>'form-control', 'disabled']) !!}
                            {!! $errors->first('nik', '<p class="help-block">:message</p>') !!}                
                        </div>
                        <div class="form-group {{$errors->has('tanggal') ? 'has-error' : '' }}">
                            {!! Form::label('tanggal', 'Tanggal') !!}
                            {!! Form::text('tanggal', $st_absen->tanggal ,['class'=>'form-control', 'disabled']) !!}
                            {!! $errors->first('tanggal', '<p class="help-block">:message</p>') !!}                
                        </div>
                        <div class="form-group {{$errors->has('status') ? 'has-error' : '' }}">
                            {!! Form::label('status', 'Status') !!}
                            {!! Form::text('status', $st_absen->statusKehadiran ,['class'=>'form-control', 'disabled']) !!}
                            {!! $errors->first('status', '<p class="help-block">:message</p>') !!}                
                        </div>
                        <div class="form-group {{$errors->has('keterangan') ? 'has-error' : '' }}">
                            {!! Form::label('keterangan', 'Keterangan') !!}
                            {!! Form::select('keterangan', array('Tanpa Keterangan' => 'Tanpa Keterangan', 'Izin' => 'Izin'),'-',['class'=>'form-control']) !!}
                            {!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}                
                        </div>
                        {!! Form::submit('Simpan', ['class'=>'btn btn-primary pull-right']) !!}
                    {!! Form::close() !!}
            </div>
        </div>
        </div>
    </div>
@endsection