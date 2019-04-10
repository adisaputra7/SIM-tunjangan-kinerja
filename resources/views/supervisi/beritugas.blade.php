@extends('layouts.home')

@section('core')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Beri Tugas</li>
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
    <div class="row">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Pemberian Tugas</div>
                <div class="card-body">
                    <form role="form" method="POST" action="add_tugas">
                        <div class="col-sm-12">
                            <label>Judul Tugas</label>
                            <input class="form-control" placeholder="" name= "judul_tugas" value="{{ old('judul_tugas') }}" autofocus>
                        </div>
                        <div class="col-sm-12">
                            <label> Penjelasan Tugas </label>
                            <textarea name="penjelasan" value="" class = "form-control" rows="8"autofocus></textarea>
                        </div>
                        <div class="col-sm-12">
                            <label>Batas Akhir Tugas</label>
                            <div class="input-group date" id="datetimepicker">
                                <input type="date" class="form-control date" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" id="datepicker">
                                <span class="input-group-addon" id="datepicker">
                                </span>     
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Pilih Pegawai</label>
                                <select name="pegawai" class="form-control" autofocus>
                                <option value="{{ old('pegawai') }}" selected>{{ old('pegawai') }}</option>
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <br>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            <button type="reset" class="btn btn-danger pull-right" style="margin-right: 10px;">Reset</button>
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>    
        </div>
    </div>
@endsection