<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPembelianModel extends Model
{
	protected $table = 'detail_pembelians';

	public function pembelian()
	{
		return $this->belongsTo('App\PembelianModel', 'faktur_pembelian')->withDefault();
	}
	public function barang()
	{
		return $this->belongsTo('App\BarangModel', 'kode_barang')->withDefault();
	}
}
