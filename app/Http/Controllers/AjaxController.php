<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\BarangModel;
use App\DetailPembelianModel;
use App\DetailPenjualanModel;
use App\DetailReturPembelianModel;
use App\DetailReturPenjualanModel;
use App\JenisBarangModel;
use App\KonversiBarangModel;
use App\MetodeModel;
use App\NotifModel;
use App\PelangganModel;
use App\PembelianModel;
use App\PenjualanModel;
use App\SupplierModel;
use DB;

class AjaxController extends Controller
{
    public function getAjaxBarangbyJenis(Request $request)
    {
        if(!is_null($request->jenis))
        {
            $barang = BarangModel::where('aktif', 1)->where('jenis_id', $request->jenis)->get();
        }
        if($barang != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $barang
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> ''
            ];
        }
        return response()->json($result); 
    }
    public function getAjaxBarkodeBarang(Request $request)
    {
        if(!is_null($request->barcode))
        {
            if(substr($request->barcode, 0, 2) == "B-")
                $barang = BarangModel::where('kode', $request->barcode)->with('jenisbarang')->first();
            else
                $barang = BarangModel::where('barcode', $request->barcode)->with('jenisbarang')->first();
        }
        if($barang != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $barang
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> $barang
            ];
        }
        return response()->json($result);
    }
    public function getAjaxBarangbyKode(Request $request)
    {
        if(!is_null($request->kode))
        {
            $barang = BarangModel::with('satuan')->where('kode', $request->kode)->first();
        }
        if($barang != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $barang
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> $barang
            ];
        }
        return response()->json($result);
    }
    public function getAjaxNamaBarang(Request $request)
    {
        if(!is_null($request->nama))
        {
            $barang = BarangModel::where('nama', 'like', '%'.$request->nama.'%')->with('jenisbarang')->get();
        }
        if($barang != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $barang
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> $barang
            ];
        }
        return response()->json($result);
    }
    public function getAjaxSupplier(Request $request)
    {
        if(!is_null($request->id))
        {
            $supplier = SupplierModel::find($request->id);
        }
        if($supplier != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $supplier
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> ''
            ];
        }
        return response()->json($result); 
    }
    public function getAjaxPelanggan(Request $request)
    {
        if(!is_null($request->id))
        {
            $pelanggan = PelangganModel::find($request->id);
            $penjualans = PenjualanModel::where('pelanggan_id', $pelanggan->id)->select('no_faktur')->orderBy('no_faktur', 'DESC')->take(10)->get();
        }
        $history = [];
        foreach ($penjualans as $key => $penjualan) {
            $history[]= [
                'id' => encrypt($penjualan->no_faktur),
                'no_faktur' => $penjualan->no_faktur
            ];
        }
        if($pelanggan != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $pelanggan,
                    'history' => $history
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> '',
                    'history' => ''
            ];
        }
        return response()->json($result);
    }

    public function getPenjualanChart1()
    {
        $penjualanschart = PenjualanModel::select(DB::raw('count(no_faktur) as sale_count, MONTH(created_at) as bulan, YEAR(created_at) as tahun'))->where('aktif', 1)->where('created_at', '>=', (new \Carbon\Carbon)->submonths(6))->groupBy('bulan', 'tahun')->get();

        if($penjualanschart != null)
        {
            $result = [
                'success' => true,
                'data'=> $penjualanschart
            ];
        }
        else
        {
            $result = [
                'success' => false,
                'data'=> ''
            ];
        }
        return response()->json($result);
    }
    public function getPenjualanChart2()
    {
//         $query = "SELECT SUM((d.harga_barang_diskon - b.harga_beli) * d.jmlh) as total, MONTH(p.created_at) as bulan, YEAR(p.created_at) as tahun
// FROM detail_penjualans d
// JOIN penjualans p ON d.faktur_penjualan = p.no_faktur
// JOIN barangs b ON d.kode_barang = b.kode
// WHERE p.created_at  >= NOW() - INTERVAL 3 MONTH
// GROUP BY bulan, tahun";
        $penjualanschart = DetailPenjualanModel::select(DB::raw('SUM((detail_penjualans.harga_barang_diskon - barangs.harga_beli) * detail_penjualans.jmlh) as total, MONTH(penjualans.created_at) as bulan , YEAR(penjualans.created_at) as tahun'))
                        ->leftJoin('penjualans', 'detail_penjualans.faktur_penjualan', '=', 'penjualans.no_faktur')
                        ->leftJoin('barangs', 'detail_penjualans.kode_barang', '=', 'barangs.kode')
                        ->where('penjualans.created_at', '>=', (new \Carbon\Carbon)->submonths(6))
                        ->groupBy('bulan', 'tahun')
                        ->get();
        if($penjualanschart != null)
        {
            $result = [
                'success' => true,
                'data'=> $penjualanschart
            ];
        }
        else
        {
            $result = [
                'success' => false,
                'data'=> ''
            ];
        }
        return response()->json($result);
    }

    public function getAjaxPenjualan(Request $request)
    {
        if(!is_null($request->faktur))
        {
            $faktur = PenjualanModel::where('no_faktur', $request->faktur)->with(['pelanggan', 'metode'])->first();
            $details = DetailPenjualanModel::where('faktur_penjualan', $request->faktur)->with('barang')->get();
        }
        if($faktur != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $faktur,
                    'details' => $details
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> $faktur,
                    'details' => $details
            ];
        }
        return response()->json($result);
    }
    public function getAjaxPenjualanByPelanggan(Request $request)
    {
        if(!is_null($request->pelanggan))
        {
            $faktur = PenjualanModel::where('pelanggan_id', $request->pelanggan)->select('no_faktur')->orderBy('no_faktur', 'DESC')->take(15)->get();
        }
        if($faktur != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $faktur
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> ''
            ];
        }
        return response()->json($result);
    }
    public function getAjaxPembelian(Request $request)
    {
        $faktur = PembelianModel::where('no_faktur', $request->faktur)->with('supplier')->first();
        $details = DetailPembelianModel::where('faktur_pembelian', $request->faktur)->with('barang')->get();
        if($faktur != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $faktur,
                    'details' => $details
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> '',
                    'details' => ''
            ];
        }
        return response()->json($result);
    }
    public function getAjaxPembelianBySupplier(Request $request)
    {
        if(!is_null($request->supplier))
        {
            $faktur = PembelianModel::where('supplier_id', $request->supplier)->select('no_faktur')->orderBy('no_faktur', 'DESC')->take(15)->get();
        }
        if($faktur != null)
        {
            $result = [
                    'success' => true,
                    'data'=> $faktur
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'data'=> ''
            ];
        }
        return response()->json($result);
    }

    public function cekNotifikasi()
    {
        $notifs = NotifModel::where('aktif', 1)->orderBy('id', 'DESC')->get();
        $result = [
            'success' => true,
            'data'=> $notifs
        ];
        return response()->json($result);
    }
    public function insertNotifBarang()
    {
        $barangs = BarangModel::where('stok', '<=', 'stok_min')->where('aktif', 1)->get();
        if($barangs != null)
        {
            foreach($barangs as $barang)
            {
                $notif = new NotifModel();
                $notif->pesan = 'Stok '.$barang->nama.' ('.$barang->kode.') TERSISA '.$barang->stok.'. Mohon dicek dan lakukan restok barang';
                $notif->kode_barang = $barang->kode;
                $notif->creator = Auth::user()->id;
                $notif->aktif = 1;
                $notif->save();
            }
        }
        $msg = 'berhasil';
        return response()->json($msg);
    }
    public function ubahNotifikasi(Request $request)
    {
        if(!is_null($request->id))
        {
            $notif = NotifModel::find($request->id);
            $notif->aktif = 0;
            $notif->save();
            $result = true;
        }
        else
            $result = false;
        return response()->json($result);
    }
}
