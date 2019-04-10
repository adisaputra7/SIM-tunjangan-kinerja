<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\SKP;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 

        // Membuat Role dan User Pegawai
        $pegawaiRole = new Role();
        $pegawaiRole->name = "pegawai";
        $pegawaiRole->display_name = "Pegawai Dinas";
        $pegawaiRole->save();

        // Membuat Role dan User Pimpinan
        $pimpinanRole = new Role();
        $pimpinanRole->name = "pimpinan";
        $pimpinanRole->display_name = "Pimpinan Dinas";
        $pimpinanRole->save();

        // Membuat Role HRD
        $hrdRole = new Role();
        $hrdRole->name = "hrd";
        $hrdRole->display_name = "Divisi HRD";
        $hrdRole->save();

        // Membuat Role dan User Supervisi
        $superVisiRole = new Role();
        $superVisiRole->name = "supervisi";
        $superVisiRole->display_name = "Supervisi Divisi";
        $superVisiRole->save();
     
        // Membuat Role dan User Keuangan
        $keuanganRole = new Role();
        $keuanganRole->name = "keuangan";
        $keuanganRole->display_name = "Divisi Keuangan";
        $keuanganRole->save();

        //Membuat Sample Users
        $pegawai = new User();
        $pegawai->nama = "Miqdad Abdurrahman Fawwaz";
        $pegawai->email = "miqdad.fawwaz@gmail.com";
        $pegawai->password = bcrypt('miqdad123');
        $pegawai->save();
        $pegawai->attachRole($pegawaiRole);

        $pimpinanRole = new User();
        $pimpinanRole->nama = "Nur Hadi Saputra";
        $pimpinanRole->email = "nurhadisaputra7@gmail.com";
        $pimpinanRole->password = bcrypt('hadi123');
        $pimpinanRole->save();
        $pimpinanRole->attachRole($pimpinanRole);

        $hrdRole = new User();
        $hrdRole->nama="Emiel Noor Kautsar";
        $hrdRole->email = "emiel.jundy@gmail.com";
        $hrdRole->password = bcrypt('emiel123');
        $hrdRole->save();
        $hrdRole->attachRole($hrdRole);

        $superVisiRole = new User();
        $superVisiRole->nama="Ardhea Citra Pertiwi";
        $superVisiRole->email = "ardheacitra@gmail.com";
        $superVisiRole->password = bcrypt('dhea123');
        $superVisiRole->save();
        $superVisiRole->attachRole($superVisiRole);

        $keuanganRole = new User();
        $keuanganRole->nama="Mutiara Cikan Andani";
        $keuanganRole->email = "mutiaramca@gmail.com";
        $keuanganRole->password = bcrypt('cikan123');
        $keuanganRole->save();
        $keuanganRole->attachRole($keuanganRole);
    }
}
