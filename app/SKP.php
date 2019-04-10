<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SKP extends Model
{
    //
    protected $table = 'skps';
    protected $primaryKey = 'id';
    protected $fillable = ['nilai_skp'];

    public function users() {
        return $this->hasOne('App\User');
    }

    public function pegawais() {
        return $this->hasOne('App\Pegawai');
    }

    public function tunjangan_skps() {
        return $this->hasOne('App\Tunjangan_skp', 'skp_id');
    }
}
