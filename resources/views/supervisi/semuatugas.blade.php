@extends('layouts.home')
@section('core')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Tugas Pegawai</li>
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
                                <th>Judul</th>
                                <th>Dateline</th>
                                <th>Penjelasan</th>
                                <th>Konfirmasi Penyelesaian</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tugass as $tugas)
                            <tr>
                                <td>{{ $tugas->judul }}</td>
                                <td>{{ $tugas->dateline_tugas }}</td>
                                <td>{{ $tugas->penjelasan_tugas }}</td>
                                @if($tugas->statusFinal != 1)
                                    <td style="color: red;">Belum Selesai</td>
                                    @else
                                    <td style="color: green;">Sudah Selesai</td>
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