<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodeModel extends Model
{
    protected $table = 'metode_bayars';

    public function penjualans()
    {
    	return $this->hasMany('App\PenjualanModel', 'metode_bayar');
    }
}
