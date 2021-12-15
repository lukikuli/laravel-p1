<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KonversiBarangModel extends Model
{
    protected $table = 'konversi_barangs';
    
	public function barangmasuk()
	{
		return $this->belongsTo('App\BarangModel', 'kode_barang_masuk')->withDefault();
	}
	public function barangkeluar()
	{
		return $this->belongsTo('App\BarangModel', 'kode_barang_keluar')->withDefault();
	}
}
