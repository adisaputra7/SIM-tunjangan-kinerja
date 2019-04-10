@extends('layouts.home')
@section('core')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Daftar Tugas</li>
</ol>
<div class="card card-default">
    <div class="card-header">
        Log Tugas Pegawai
    </div>
    <div class="card-body">
        <div class="row">
            <div class="container">
                <div class="col-lg-12">
                    <table id="listtugas" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>Tanggal Dikumpulkan</th>
                                <th>Pesan</th>
                                <th>File</th>
                                <th>Konfirmasi Penyelesaian</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($kumpuls as $kumpul)
                            <tr>
                                <td>{{ $kumpul->nama }}</td>
                                <td>{{ $kumpul->created_at }}</td>
                                <td>{{ $kumpul->pesan }}</td>
                                @if( $kumpul->attachment != NULL )
                                    <td><a href="{{ $kumpul->attachment }}">Download File</a></td>
                                @else
                                    <td>Tidak Ada File</td>
                                @endif
                                @if($kumpul->statusFinal !=1 )
                                    <td><a href="/konfirmasi_penyelesaian/{{$kumpul->idTugas}}">Konfirmasi</a></td>
                                @else
                                    <td>Sudah Selesai</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection