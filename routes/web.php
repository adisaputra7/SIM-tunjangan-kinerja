<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'LoginController@login');
Route::get('/logout','Auth\LoginController@logout')->name('logout');
Auth::routes();
Route::get('/', 'HomeController@index');

Route::group(['middleware'=>['auth']], function(){
    Route::resource('profile', 'ProfileController');
    Route::post('store/profile', 'ProfileController@store');
});

Route::group(['prefix'=>'pimpinan', 'middleware'=>['auth', 'role:pimpinan']], function(){
    Route::resource('pemberian-skp', 'PimpinanController');
    Route::post('/exportExcel', [
        'as' => 'export.pimpinan.post',
        'uses' => 'PimpinanController@exportPost'
    ]);
});

Route::group(['middleware'=>['auth', 'role:supervisi']], function(){
    Route::get('/beri_tugas', 'SupervisiController@getAllPegawai');
    Route::post('/add_tugas', 'SupervisiController@addTugas');
    Route::get('/daftar_tugas', 'SupervisiController@getAllTugas');
    Route::get('/pengumpulan', 'SupervisiController@pengumpulanTugas');
    Route::get('/konfirmasi_penyelesaian/{id_tugas}', 'SupervisiController@konfirmasiTugas');
});

Route::group(['middleware'=>['auth', 'role:pegawai']], function(){
    Route::get('/tugas_pegawai', 'PegawaiController@tugasPegawai');
    Route::get('/detail_tugas/{id_tugas}', 'PegawaiController@detailTugasPegawai');
    Route::post('detail_tugas/{id_tugas}', [
        "uses" =>'PegawaiController@kumpulkanTugasPegawai',
        'as' => 'kumpulkan']);
});

Route::group(['prefix'=>'hrd', 'middleware'=>['auth', 'role:hrd']], function() {
    Route::resource('rekapitulasi-absensi', 'HrdController');
    Route::get('/tugas_hrd', 'HrdController@tugasHrd');
    Route::get('/detail_tugas_hrd/{id_tugas}', 'HrdController@detailTugasHrd');
    Route::post('detail_tugas_hrd/{id_tugas}', [
        "uses" =>'HrdController@kumpulkanTugasHrd',
        'as' => 'kumpulkanHrd']);
    Route::post('/exportExcel', [
        'as' => 'export.hrd.post',
        'uses' => 'HrdController@exportPost'
    ]);
});

Route::group(['prefix'=>'keuangan', 'middleware'=>['auth', 'role:keuangan']], function() {
    Route::resource('tunjangan', 'KeuanganController');
    Route::get('/tugas_keuangan', 'KeuanganController@tugasKeuangan');
    Route::get('/detail_tugas_keuangan/{id_tugas}', 'KeuanganController@detailTugasKeuangan');
    Route::post('detail_tugas_keuangan/{id_tugas}', [
        "uses" =>'KeuanganController@kumpulkanTugasKeuangan',
        'as' => 'kumpulkanKeuangan']);
    Route::post('/exportExcel', [
        'as' => 'export.keuangan.post',
        'uses' => 'KeuanganController@exportPost'
    ]);
});
