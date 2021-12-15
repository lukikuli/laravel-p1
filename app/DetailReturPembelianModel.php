<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailReturPembelianModel extends Model
{
    protected $table = 'detail_retur_pembelians';

	public function returpembelian()
	{
		return $this->belongsTo('App\ReturPembelianModel', 'retur_pembelian')->withDefault();
	}
	public function barang()
	{
		return $this->belongsTo('App\BarangModel', 'kode_barang')->withDefault();
	}
}
