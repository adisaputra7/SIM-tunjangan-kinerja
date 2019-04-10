<?php

use Illuminate\Database\Seeder;
use App\Pegawai;

class PegawaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        Pegawai::truncate();
        Pegawai::create([
            'nama' => 'Miqdad Abdurrahman Fawwaz',
            'nik' => '198503302003121001',
            'divisi' => 'IT',
            'user_id' => 1,
            'skp_id' => 1,
            'grade_id' => 5,
        ]);
        Pegawai::create([
            'nama' => 'Nur Hadi Saputra',
            'nik' => '198503302003121002',
            'divisi' => 'Executive Manager',
            'user_id' => 2,
            'skp_id' => 2,
            'grade_id' => 17,
        ]);
        Pegawai::create([
            'nama' => 'Emiel Noor Kautsar',
            'nik' => '198503302003121003',
            'divisi' => 'HRD',
            'user_id' => 3,
            'skp_id' => 3,
            'grade_id' => 8,
        ]);
        Pegawai::create([
            'nama' => 'Ardhea Citra Pertiwi',
            'nik' => '198503302003121004',
            'divisi' => 'Kemasyarakatan',
            'user_id' => 4,
            'skp_id' => 4,
            'grade_id' => 10,
        ]);
        Pegawai::create([
            'nama' => 'Mutiara Cikan Andani',
            'nik' => '198503302003121005',
            'divisi' => 'Keuangan',
            'user_id' => 5,
            'skp_id' => 5,
            'grade_id' => 12,
        ]);
    }
}
