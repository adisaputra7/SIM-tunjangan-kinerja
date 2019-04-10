@extends('layouts.home')

@section('core')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">HRD</a>
        </li>
        <li class="breadcrumb-item active">Absensi</li>
    </ol>

    <div class="card card-default">
        <div class="card-header">Tambah Record Absensi</div>
        <div class="card-body">
            {!! Form::open(['url' => route('rekapitulasi-absensi.store'), 'method' => 'POST ']) !!}
            <div class="form-group {!! $errors->has('pegawai_id') ? 'has-error' : '' !!}">
                {!! Form::label('pegawai_id', 'Nama Pegawai') !!}
                {!! Form::select('pegawai_id', [''=>'']+App\Pegawai::pluck('nama','id')->all(), null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group {!! $errors->has('status_id') ? 'has-error' : '' !!}">
                {!! Form::label('status_id', 'Status') !!}
                <div class="radio">
                    {!! Form::radio('status_id', 'Hadir', true) !!} Hadir
                    {!! Form::radio('status_id', 'Tidak Hadir', false) !!} Tidak Hadir
                </div>
            </div>
            <div class="form-group {!! $errors->has('time_masuk') ? 'has-error' : '' !!}">
                {!! Form::label('time_masuk', 'Jam Masuk') !!}
                <!-- <input class="form-control" type="text" id="time_masuk"> -->
                {!! Form::text('time_masuk', 0, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group {!! $errors->has('time_keluar') ? 'has-error' : '' !!}">
                {!! Form::label('time_keluar', 'Jam Keluar') !!}
                <!-- <input class="form-control" type="text" id="time_keluar"> -->
                {!! Form::text('time_keluar', 0, ['class' => 'form-control']) !!}
            </div>
            {!! Form::submit('Simpan', ['class'=>'btn btn-primary pull-right']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('scripts')
    <script>
        $('#time_masuk, #time_keluar').datetimepicker({
            format: 'HH:mm:ss'
        });
    </script>
@endsection