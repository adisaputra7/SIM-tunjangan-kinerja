<?php

use Illuminate\Database\Seeder;
use App\SKP;

class SkpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SKP::create([
            'nilai_skp' => '90',
        ]);
        SKP::create([
            'nilai_skp' => '63',
        ]);
        SKP::create([
            'nilai_skp' => '82',
        ]);
        SKP::create([
            'nilai_skp' => '64',
        ]);
        SKP::create([
            'nilai_skp' => '98',
        ]);
    }
}
