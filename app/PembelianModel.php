<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class PembelianModel extends Model
{
	protected $table = 'pembelians';
    protected $primaryKey = 'no_faktur';
    protected $keyType = 'string';
    public $incrementing = false;

    public function detailpembelians()
    {
    	return $this->hasMany('App\DetailPembelianModel', 'faktur_pembelian')->withDefault();
    }
    public function supplier()
    {
    	return $this->belongsTo('App\SupplierModel', 'supplier_id')->withDefault();
    }
    public function returpembelians()
    {
        return $this->hasMany('App\ReturPembelianModel', 'faktur_pembelian')->withDefault();
    }
    public static function getKodePembelian()
    {
        $datetime = \Carbon\Carbon::now();
        $datetime = $datetime->setTimeZone('Asia/Bangkok');
        $thn = $datetime->format('Y');
        $bln = $datetime->format('m');
        $data = DB::table('pembelians')->select('no_faktur')->orderBy('no_faktur', 'desc')->first();
        if(is_null($data))
        {
            $nobaru = 1;
            $kodebaru = "000".(string)$nobaru;
            $kodebaru = "PO/".$thn.$bln."/".substr($kodebaru, -4);
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
            $kodebaru = "PO/".$thn.$bln."/".substr($kodebaru, -4);
        }
        return $kodebaru;
    }
}
