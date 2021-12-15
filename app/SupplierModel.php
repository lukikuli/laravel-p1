<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    protected $table = 'suppliers';

    public function pembelians()
    {
    	return $this->hasMany('App\PembelianModel', 'supplier_id');
    }
}
