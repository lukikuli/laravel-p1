<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    protected $table = 'barangs';
    protected $primaryKey = 'kode';
    protected $keyType = 'string';
    public $incrementing = false;

    public function jenisbarang()
    {
    	return $this->belongsTo('App\JenisBarangModel', 'jenis_id')->withDefault();
    }
    public function satuan()
    {
        return $this->belongsTo('App\SatuanModel', 'satuan_id')->withDefault();
    }
    public function detailpembelians()
    {
        return $this->hasMany('App\DetailPembelianModel', 'kode_barang');
    }
    public function detailpenjualans()
    {
        return $this->hasMany('App\DetailPenjualanModel', 'kode_barang');
    }
    public function detailreturpembelians()
    {
        return $this->hasMany('App\DetailReturPembelianModel', 'kode_barang');
    }
    public function detailreturpenjualans()
    {
        return $this->hasMany('App\DetailReturPenjualanModel', 'kode_barang');
    }
    public function konversibarangmasuks()
    {
        return $this->hasMany('App\KonversiBarangModel', 'kode_barang_masuk');
    }
    public function konversibarangkeluars()
    {
        return $this->hasMany('App\KonversiBarangModel', 'kode_barang_keluar');
    }
    public static function getKodeBarang()
    {
    	//$kode = $this::first();
    	$data = DB::table('barangs')->select('kode')->orderBy('kode', 'desc')->first();
    	if(is_null($data))
    	{
    		$nobaru = 1;
    		$kodebaru = "000".(string)$nobaru;
    		$kodebaru = "B-".substr($kodebaru, -4);
    	}
    	else
    	{
            $kode = $data->kode;
    		$nobaru = (int)(substr($kode, 2, 4)) + 1;
    		$kodebaru = "000".(string)$nobaru;
    		$kodebaru = "B-".substr($kodebaru, -4);
    	}
    	return $kodebaru;
    }
}
