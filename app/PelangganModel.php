<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PelangganModel extends Model
{
    protected $table = 'pelanggans';

    public function penjualans()
    {
    	return $this->hasMany('App\PenjualanModel', 'pelanggan_id');
    }
}
