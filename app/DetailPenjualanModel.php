<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualanModel extends Model
{
	protected $table = 'detail_penjualans';

	public function penjualan()
	{
		return $this->belongsTo('App\PenjualanModel', 'faktur_penjualan')->withDefault();
	}
	public function barang()
	{
		return $this->belongsTo('App\BarangModel', 'kode_barang')->withDefault();
	}
}
