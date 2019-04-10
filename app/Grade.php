<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['grade','tunjangan'];
    public function pegawai() {
        return $this->hasOne('App\Pegawai');
    }
}
