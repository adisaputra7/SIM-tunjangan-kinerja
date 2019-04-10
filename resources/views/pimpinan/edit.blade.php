@extends('layouts.home')

@section('core')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Pimpinan</a>
        </li>
        <li class="breadcrumb-item active"><a href="{{ url('pimpinan/pemberian-skp') }}">Daftar Kinerja</a></li>
        <li class="breadcrumb-item active">Pemberian SKP</li>
    </ol>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">Pemberian SKP</div>
                <div class="card-body">
                    {!! Form::model($pegawai, ['url'=>route('pemberian-skp.update', $pegawai->id), 
                    'method'=>'PUT']) !!}
                        <div class="form-group {{$errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name', 'Nama Pegawai') !!}
                            {!! Form::text('name', $pegawai->nama ,['class'=>'form-control', 'disabled']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}                
                        </div>
                        <div class="form-group {{$errors->has('nik') ? 'has-error' : '' }}">
                            {!! Form::label('nik', 'NIK Pegawai') !!}
                            {!! Form::text('nik', $pegawai->nik ,['class'=>'form-control', 'disabled']) !!}
                            {!! $errors->first('nik', '<p class="help-block">:message</p>') !!}                
                        </div>
                        <div class="form-group {{$errors->has('nilaiSKP') ? 'has-error' : '' }}">
                            {!! Form::label('nilai_skp', 'SKP Pegawai') !!}
                            {!! Form::number('nilai_skp', $pegawai->skp->nilai_skp ,['class'=>'form-control']) !!}
                            {!! $errors->first('nilai_skp', '<p class="help-block">:message</p>') !!}                
                        </div>
                        {!! Form::submit('Simpan', ['class'=>'btn btn-primary pull-right']) !!}
                    {!! Form::close() !!}
            </div>
        </div>
        </div>
    </div>
@endsection

