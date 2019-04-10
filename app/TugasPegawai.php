<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TugasPegawai extends Model
{
    protected $table = "tugas_pegawai";
    protected $primaryKey = "idTugas";
    public $timestamps = false;
}
