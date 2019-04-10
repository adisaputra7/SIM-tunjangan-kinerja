<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tunjangan_skp extends Model
{
    //
    protected $fillable = ['nilai','potongan', 'skp_id'];

    public function skp() {
        return $this->belongsTo('App\SKP');
    }
}
