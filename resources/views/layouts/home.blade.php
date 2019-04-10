@extends('layouts.app')

@section('content')
   <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="#">
      <img src="{{ asset('images/kab_bogor_logo.png') }}" 
      alt="Logo Kab Bogor" width="8%" height="8%" style="margin-right: 10px;">
        SIM Tunjangan Kinerja
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="profile-header-container"title="Photo">
          <img src="{{ asset($imageName) }}" alt="Photo Profile" 
            class="rounded-circle" width="55" height="55" >
        </li>
        <li class="profile-header-container"title="Nama" >
          <span class="nav-link-text">{{ $namaPegawai }}</span>
        </li>   
        <li class="profile-name-header-container"title="Nama" >
          <span class="nav-link-text">{{ $nikPegawai }}</span>
        </li>   
        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="{{ url('/') }}">
            <i class="fa fa-fw fa-dashboard "></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <!-- Begin Layout Pimpinan-->
        @role('pimpinan')
        <li class="nav-item {{ Request::is('/beri_tugas') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right"
        title="Pemberian SKP">
          <a class="nav-link" href="{{ url('/pimpinan/pemberian-skp') }}">
            <i class="fa fa-area-chart" aria-hidden="true"></i>
            <span class="nav-link-text">Daftar Kinerja</span>
          </a>
        </li>
        @endrole
      <!--End Layout Pimpinan-->
      <!-- Begin Layout HRD-->
      @role('hrd')
        <li class="nav-item {{ Request::is('/hrd/rekapitulasi-absensi/create') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right"
        title="Pemberian SKP">
          <a class="nav-link" href="{{ url('/hrd/rekapitulasi-absensi/create') }}">
            <i class="fa fa-area-chart" aria-hidden="true"></i>
            <span class="nav-link-text">Absensi</span>
          </a>
        </li>
        <li class="nav-item {{ Request::is('/hrd/absensi') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right"
        title="Rekapitulasi Absensi">
          <a class="nav-link" href="{{ url('/hrd/rekapitulasi-absensi') }}">
            <i class="fa fa-check-square-o" aria-hidden="true"></i>
            <span class="nav-link-text">Rekapitulasi Absensi</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pemberian Tugas">
          <a class="nav-link" href="/hrd/tugas_hrd">
            <i class="fa fa-hourglass-half" aria-hidden="true"></i>
            <span class="nav-link-text">Tugas Belum Dikerjakan</span>
          </a>
      @endrole
      <!--End Layout HRD-->
      <!-- Keuangan -->
      @role('keuangan')
        <li class="nav-item {{ Request::is('/keuangan/tunjangan') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right"
        title="Daftar Tunjangan">
          <a class="nav-link" href="{{ url('/keuangan/tunjangan') }}">
            <i class="fa fa-usd" aria-hidden="true"></i>
            <span class="nav-link-text">Daftar Tunjangan</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pemberian Tugas">
          <a class="nav-link" href="{{ url('keuangan/tugas_keuangan') }}">
            <i class="fa fa-check-square-o" aria-hidden="true"></i>
            <span class="nav-link-text">Tugas Belum Dikerjakan</span>      
          </a>
        </li>
      @endrole
      <!-- End layout keuangan -->
      <!-- Supervisi -->
      @role('supervisi')
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pemberian Tugas">
          <a class="nav-link" href="/beri_tugas">
            <i class="fa fa-bullhorn" aria-hidden="true"></i>
            <span class="nav-link-text">Pemberian Tugas</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pemberian Tugas">
          <a class="nav-link" href="/pengumpulan">
            <i class="fa fa-check-square-o" aria-hidden="true"></i>
            <span class="nav-link-text">Pengumpulan Oleh Pegawai</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pemberian Tugas">
          <a class="nav-link" href="/daftar_tugas">
            <i class="fa fa-file-text-o" aria-hidden="true"></i>
            <span class="nav-link-text">Log Tugas Pegawai</span>
          </a>
        </li>
        @endrole
        <!-- End layout supervisi -->
        @role('pegawai')
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pemberian Tugas">
          <a class="nav-link" href="/tugas_pegawai">
            <i class="fa fa-hourglass-half" aria-hidden="true"></i>
            <span class="nav-link-text">  Tugas Belum Dikerjakan</span>
          </a>
        </li>
        @endrole
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <div class="row">
             <a class="nav-link" href="{{ url('/profile') }}">
            Welcome, {{ Auth::user()->nama }}
          </a>
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
    @include('layouts._flash') 
    @yield('core')
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyrights © SIM Tunjangan Kinerja 2017</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Anda Yakin?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Pilih "Logout" jika Anda ingin meninggalkan sesi ini.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="{{ url('logout') }}">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
