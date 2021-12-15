<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class ReturPembelianModel extends Model
{
    
	protected $table = 'retur_pembelians';
    protected $primaryKey = 'no_retur';
    protected $keyType = 'string';
    public $incrementing = false;

    public function detailreturpembelians()
    {
        return $this->hasMany('App\DetailReturPembelianModel', 'retur_pembelian');
    }
    public function pembelian()
    {
    	return $this->belongsTo('App\PembelianModel', 'faktur_pembelian')->withDefault();
    }

    public static function getKodeReturPembelian()
    {
        $datetime = \Carbon\Carbon::now();
        $datetime = $datetime->setTimeZone('Asia/Bangkok');
        $thn = $datetime->format('Y');
        $bln = $datetime->format('m');
        $data = DB::table('retur_pembelians')->select('no_retur')->orderBy('no_retur', 'desc')->first();
        if(is_null($data))
        {
            $nobaru = 1;
            $kodebaru = "000".(string)$nobaru;
            $kodebaru = "RPO/".$thn.$bln."/".substr($kodebaru, -4);
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
            $kodebaru = "RPO/".$thn.$bln."/".substr($kodebaru, -4);
        }
        return $kodebaru;
    }
}
