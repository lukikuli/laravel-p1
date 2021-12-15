<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class ReturPenjualanModel extends Model
{
    
	protected $table = 'retur_penjualans';
    protected $primaryKey = 'no_retur';
    protected $keyType = 'string';
    public $incrementing = false;

    public function detailreturpenjualans()
    {
    	return $this->hasMany('App\DetailReturPenjualanModel', 'retur_penjualan');
    }
    public function penjualan()
    {
    	return $this->belongsTo('App\PenjualanModel', 'faktur_penjualan')->withDefault();
    }

    public static function getKodeReturPenjualan()
    {
        $datetime = \Carbon\Carbon::now();
        $datetime = $datetime->setTimeZone('Asia/Bangkok');
        $thn = $datetime->format('Y');
        $bln = $datetime->format('m');
        $data = DB::table('retur_penjualans')->select('no_retur')->orderBy('no_retur', 'desc')->first();
        if(is_null($data))
        {
            $nobaru = 1;
            $kodebaru = "000".(string)$nobaru;
            $kodebaru = "RSO/".$thn.$bln."/".substr($kodebaru, -4);
        }
        else
        {
            $kode = $data->no_retur;
            $blnold = substr($kode, 8, 2);
            if($blnold != $bln)
                $nobaru = 1;
            else
                $nobaru = (int)(substr($kode, 11, 4)) + 1;
            $kodebaru = "000".(string)$nobaru;
            $kodebaru = "RSO/".$thn.$bln."/".substr($kodebaru, -4);
        }
        return $kodebaru;
    }
}
