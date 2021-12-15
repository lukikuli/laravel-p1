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
use App\PelangganModel;
use App\PembelianModel;
use App\PenjualanModel;
use App\ReturPenjualanModel;
use App\ReturPembelianModel;
use App\SupplierModel;
use App\UserModel;
use Carbon\Carbon;
use DB;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik' || Auth::user()->role == 'manager'))
        {
            $orders1 = PembelianModel::where('aktif', 1)->where('tgl_beli', Carbon::today())->get();
            $orders2 = PembelianModel::where('aktif', 1)->whereMonth('tgl_beli', Carbon::now()->month)->get();

            $suppliers = SupplierModel::where('aktif', 1)->get();

            $sales1 = PenjualanModel::where('aktif', 1)->where('tgl_jual', Carbon::today())->get();
            $sales2 = PenjualanModel::where('aktif', 1)->whereMonth('tgl_jual', Carbon::now()->month)->get();

            $pelanggans1 = $this->countCustomer($sales1);
            $pelanggans2 = $this->countCustomer($sales2);

            $penjualans = PenjualanModel::where('aktif', 1)->orderBy('no_faktur', 'DESC')->with('pelanggan')->skip(0)->take(10)->get();
            $barangs = BarangModel::where('aktif', 1)->with('satuan')->with('jenisbarang')->skip(0)->take(5)->get();

            $laba1 = 0; $laba2 = 0;
            foreach($sales1 as $sale)
            {
                foreach ($sale->detailpenjualans as $key => $detailpenjualan) {
                    $laba1 += ($detailpenjualan->harga_barang_diskon - $detailpenjualan->barang->harga_beli) * $detailpenjualan->jmlh;
                }
            }
            foreach($sales2 as $sale2)
            {
                foreach ($sale2->detailpenjualans as $key => $detailpenjualan) {
                    $laba2 += ($detailpenjualan->harga_barang_diskon - $detailpenjualan->barang->harga_beli) * $detailpenjualan->jmlh;
                }
            }

            return view('admin/dashboard', compact('orders1', 'orders2', 'sales1', 'sales2', 'pelanggans1', 'pelanggans2', 'penjualans', 'barangs', 'laba1', 'laba2'));
        }
        elseif(Auth::user()->role == 'manager')
        {
            return view('admin/home');
        }
        else
        {
            $pelanggans = PelangganModel::where('aktif', 1)->get();
            $metodes = MetodeModel::where('aktif', 1)->get();
            $kode = PenjualanModel::getKodePenjualan();
            $barangs = BarangModel::where('aktif', 1)->get();
            return view('admin/penjualan/create', compact('pelanggans', 'kode', 'metodes', 'barangs'));
        }
    }

    private function countCustomer($orders)
    {
        //ARRAY KOSONG DIDEFINISIKAN
        $customer = [];
        //JIKA TERDAPAT DATA YANG AKAN DITAMPILKAN
        if (count($orders) > 0) {
            //DI-LOOPING UNTUK MENYIMPAN EMAIL KE DALAM ARRAY
            foreach ($orders as $row) {
                $customer[] = $row->pelanggan_id;
            }
        }
        //MENGHITUNG TOTAL DATA YANG ADA DI DALAM ARRAY
        //DIMANA DATA YANG DUPLICATE AKAN DIHAPUS MENGGUNAKAN ARRAY_UNIQUE
        return count(array_unique($customer));
    }
    private function countTotal($orders)
    {
        //DEFAULT TOTAL BERNILAI 0
        $total = 0;
        //JIKA DATA ADA
        if (count($orders) > 0) {
            //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
            $sub_total = $orders->pluck('hrg_total')->all();
            //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
            $total = array_sum($sub_total);
        }
        return $total;
    }
    private function countItem($order)
    {
        //DEFAULT DATA 0
        $data = 0;
        //JIKA DATA TERSEDIA
        if (count($order) > 0) {
            //DI-LOOPING
            foreach ($order as $row) {
                //$details = DetailPenjualanModel::where('faktur_penjualan', $row->no_faktur)->pluck('jmlh')->all();
                //UNTUK MENGAMBIL QTY 
                $qty = $row->detailpenjualans->pluck('jmlh')->all();
                //KEMUDIAN QTY DIJUMLAHKAN
                $val = array_sum($qty);
                $data += $val;
            }
        } 
        return $data;
    }
}
