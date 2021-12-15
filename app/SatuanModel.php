<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatuanModel extends Model
{
    protected $table = 'satuans';

    public function barangs()
    {
    	return $this->hasMany('App\BarangModel', 'satuan_id');
    }
}
