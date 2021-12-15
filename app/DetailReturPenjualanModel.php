<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailReturPenjualanModel extends Model
{
    protected $table = 'detail_retur_penjualans';

	public function returpenjualan()
	{
		return $this->belongsTo('App\ReturPenjualanModel', 'retur_penjualan')->withDefault();
	}
	public function barang()
	{
		return $this->belongsTo('App\BarangModel', 'kode_barang')->withDefault();
	}
}
