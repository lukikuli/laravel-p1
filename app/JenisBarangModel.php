<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisBarangModel extends Model
{
    protected $table = 'jenis_barangs';

    public function barangs()
    {
    	return $this->hasMany('App\BarangModel', 'jenis_id');
    }
}
