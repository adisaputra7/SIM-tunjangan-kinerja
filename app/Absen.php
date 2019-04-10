<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absen';

    protected $fillable = ['id', 'NIP', 'tanggal', 'jamMasuk', 'jamKeluar'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function status_absens() {
       return $this->hasOne('App\Status_absen');
    }
}
