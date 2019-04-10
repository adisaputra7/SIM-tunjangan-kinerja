<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = "pegawais";
    protected $primaryKey = "id";
    protected $fillable = [
        'nama', 'nik', 'divisi','potongan', 'tunjangan', 'user_id', 'skp_id', 'grade_id'
    ];

    public function skp() {
        return $this->belongsTo('App\SKP');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function grade() {
        return $this->belongsTo('App\Grade');
    }
}
