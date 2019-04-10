<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status_absen extends Model
{
    protected $table = 'status_absen';
    protected $primaryKey = 'id';
    protected $foreignKey = 'absen_id';
    protected $fillable = ['id', 'NIP', 'tanggal', 'statusKehadiran', 'keterangan', 'absen_id'];

    public function users() {
        return $this->hasOne('App\User');
    }

    public function absen() {
       return $this->belongsTo('App\Absen');
    }
}
