@extends('layouts.home')

@section('core')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada masalah ketika mengunggah foto.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-default">
        <div class="card-header">My Profile</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset($imageName) }}" alt="Photo Profile" 
                    class="img-responsive img-thumbnail" width="100%" height="78%">
                    <form method="POST" class="form-horizontal"
                    role="form" 
                    action="{{ route('profile.store') }}"
                    enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control" type="file" name="image">
                                <br>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    Upload
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nama"><b>Nama:</b></label>
                        </div>
                        <div class="col-md-8" id="nama">
                            {{ $namaPegawai }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nip"><b>NIP:</b></label>
                        </div>
                        <div class="col-md-8" id="nip">
                            {{ $nikPegawai}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nip"><b>Divisi:</b></label>
                        </div>
                        <div class="col-md-8" id="nip">
                            {{ $divisiPegawai }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nip"><b>Nilai Capaian SKP:</b></label>
                        </div>
                        <div class="col-md-8" id="nip">
                            {{ $skpPegawai }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nip"><b>Presentase Kehadiran:</b></label>
                        </div>
                        <div class="col-md-8" id="nip">
                            {{ number_format($kehadiranPresentase * 100) }} %
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nip"><b>Tunjangan Pokok:</b></label>
                        </div>
                        <div class="col-md-8" id="nip">
                            Rp. {{ number_format($gradesPegawai) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nip"><b>Potongan Tunjangan:</b></label>
                        </div>
                        <div class="col-md-8" id="nip">
                            <span style="color:red;">Rp. {{ number_format($potonganPegawai) }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nip"><b>Tunjangan:</b></label>
                        </div>
                        <div class="col-md-8" id="nip">
                            Rp. {{ number_format($tunjanganPegawai) }}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection