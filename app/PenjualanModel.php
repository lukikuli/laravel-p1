<?php

namespace App;
 
use DB;
use Illuminate\Database\Eloquent\Model;

class PenjualanModel extends Model
{
	protected $table = 'penjualans';
	protected $primaryKey = 'no_faktur';
    protected $keyType = 'string';
    public $incrementing = false;

    public function detailpenjualans()
    {
    	return $this->hasMany('App\DetailPenjualanModel', 'faktur_penjualan');
    }
    public function metode()
    {
        return $this->belongsTo('App\MetodeModel', 'metode_bayar')->withDefault();
    }
    public function pelanggan()
    {
    	return $this->belongsTo('App\PelangganModel', 'pelanggan_id')->withDefault();
    }
    public function returpenjualans()
    {
        return $this->hasMany('App\ReturPenjualanModel', 'faktur_penjualan');
    }
    public static function getKodePenjualan()
    {
        $datetime = \Carbon\Carbon::now();
        $datetime = $datetime->setTimeZone('Asia/Bangkok');
        $thn = $datetime->format('Y');
        $bln = $datetime->format('m');
    	$data = DB::table('penjualans')->select('no_faktur')->orderBy('no_faktur', 'desc')->first();
        $kodebaru = '';
    	if(is_null($data))
    	{
    		$nobaru = 1;
    		$kodebaru = "000".(string)$nobaru;
            $kodebaru = "SO/".$thn.$bln."/".substr($kodebaru, -4);
    	}
    	else
    	{
            $kode = $data->no_faktur;
            $blnold = substr($kode, 7, 2);
            if($blnold != $bln)
                $nobaru = 1;
            else
                $nobaru = (int)(substr($kode, 10, 4)) + 1;
            $kodebaru = "000".(string)$nobaru;
            $kodebaru = "SO/".$thn.$bln."/".substr($kodebaru, -4);
    	}
    	return $kodebaru;
    }
}
