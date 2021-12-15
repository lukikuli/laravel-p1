<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PembelianModel;
use App\DetailPembelianModel;
use App\PenjualanModel;
use App\DetailPenjualanModel;
use App\ReturPenjualanModel;
use App\DetailReturPenjualanModel;
use App\ReturPembelianModel;
use App\DetailReturPembelianModel;
use App\MetodeModel;
use App\SUpplierModel;
use App\PelangganModel;
use App\UserModel;
use App\BarangModel;
use App\JenisBarangModel;
use App\KonversiBarangModel;

use App\Exports\OrderInvoice;
use Carbon\carbon;
use PDF;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    }

    public function showLaporanStokBarang(Request $request)
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik'))
        {
            $barangs = BarangModel::where('aktif', 1)->get();
            $jenisbarangs = JenisBarangModel::where('aktif', 1)->get();

            if (!empty($request->jenisbarang)) {
                $barangs = $barangs->where('jenis_id', $request->jenisbarang);
            }
            if (!empty($request->barang)) {
                $barangs = $barangs->where('kode', $request->barang);
            }
            $total = 0;
            if (count($barangs) > 0) {
                $sub = $barangs->pluck('stok')->all();
                $total = array_sum($sub);
            }
            return view('admin/laporan/barang/laporanstokbarang', compact('jenisbarangs', 'barangs', 'total'));
        }
        else
            return redirect()->back();
    }
    public function showLaporanKonversiBarang(Request $request)
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik'))
        {
            $konversis = KonversiBarangModel::where('aktif', 1)->orderBy('created_at', 'DESC');
            $jenisbarangs = JenisBarangModel::where('aktif', 1)->get();
            $barangs = BarangModel::where('aktif', 1)->get();
         
            if (!empty($request->jenisbarang)) {
                $value = $request->jenisbarang;
                $konversis = $konversis->whereHas('barangkeluar', function($q) use($value) { $q->where('jenis_id', '=', $value); })->orWhereHas('barangmasuk', function($q) use($value) { $q->where('jenis_id', '=', $value); });
            }
            if (!empty($request->barang)) {
                $konversis = $konversis->where('kode_barang_keluar', $request->barang)->orWhere('kode_barang_masuk', $request->barang);
            }
            if (!empty($request->start_date) && !empty($request->end_date))
            {
                $value1 = $request->start_date;
                $value2 = $request->end_date;
                $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';
                $konversis = $konversis->where(function($q) use($value1, $value2) { $q->whereBetween('tgl_konversi', [$value1, $value2]); })->get();
            }
            else 
            {
                $konversis = $konversis->get();
            }
            $total1 = 0;
            $total2 = 0;
            if (count($konversis) > 0) {
                $sub1 = $konversis->pluck('stok_keluar')->all();
                $total1 = array_sum($sub1);
                $sub2 = $konversis->pluck('stok_masuk')->all();
                $total2 = array_sum($sub2);
            }
            return view('admin/laporan/konversibarang/laporankonversibarang', compact('konversis', 'jenisbarangs', 'barangs', 'total1', 'total2'));
        }
        else
            return redirect()->back();
    }
    public function showLaporanPembelianSupplier(Request $request)
    {
        $orders = PembelianModel::where('aktif', 1)->orderBy('tgl_beli', 'DESC');
        $suppliers = SupplierModel::where('aktif', 1)->orderBy('nama', 'ASC')->get();

        if (!empty($request->supplier)) {
            $orders = $orders->where('supplier_id', $request->supplier);
        }
        if (!empty($request->start_date) && !empty($request->end_date))
        {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';
            $orders = $orders->whereBetween('tgl_beli', [$start_date, $end_date]);
        }
        $orders = $orders->get();
        $total = 0;
        //JIKA DATA ADA
        if (count($orders) > 0) {
            //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
            $sub = $orders->pluck('hrg_total')->all();
            //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
            $total = array_sum($sub);
        }
        return view('admin/laporan/pembelian/laporanpembeliansupplier', compact('orders', 'suppliers', 'total'));
    }
    public function showLaporanPembelianDetail(Request $request)
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik' || Auth::user()->role == 'manager'))
        {
            $orders = PembelianModel::with('detailpembelians')->where('aktif', 1)->orderBy('tgl_beli', 'DESC');
            $suppliers = SupplierModel::where('aktif', 1)->orderBy('nama', 'ASC')->get();
            $barangs = BarangModel::where('aktif', 1)->get();

            if (!empty($request->supplier)) {
                $orders = $orders->where('supplier_id', $request->supplier);
            }
            if (!empty($request->barang)) {
                $value = $request->barang;
                $orders = $orders->whereHas('detailpembelians', function($q) use($value) { $q->where('kode_barang', $value); });
            }
            if (!empty($request->start_date) && !empty($request->end_date))
            {
                $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';
                $orders = $orders->whereBetween('tgl_beli', [$start_date, $end_date]);
            }
            $orders = $orders->get();
            $total = 0;
            $total1 = 0;
            //JIKA DATA ADA
            if (count($orders) > 0) {
                //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
                $sub = $orders->pluck('jmlh')->all();
                //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
                $total = array_sum($sub);
            }
            foreach ($orders as $order) {
                $total1 += $order->hrg_total;
            }
            return view('admin/laporan/pembelian/laporanpembeliandetail', compact('orders', 'suppliers', 'barangs', 'total', 'total1'));
        }
        else
            return redirect()->back();
        // $orders = DetailPembelianModel::with('pembelian')->whereHas('pembelian', function($q) { $q->where('aktif', '=', 1); })
        //         ->orderBy('created_at', 'DESC');
        // $suppliers = SupplierModel::where('aktif', 1)->orderBy('nama', 'ASC')->get();
        // $barangs = BarangModel::where('aktif', 1)->get();

        // if (!empty($request->supplier)) {
        //     $value = $request->supplier;
        //     $orders = $orders->whereHas('pembelian', function($q) use($value) { $q->where('supplier_id', '=', $value); });
        // }
        // if (!empty($request->barang)) {
        //     $orders = $orders->where('kode_barang', $request->barang);
        // }
        // if (!empty($request->start_date) && !empty($request->end_date))
        // {
        //     $value1 = $request->start_date;
        //     $value2 = $request->end_date;
        //     $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
        //     $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';
        //     $orders = $orders->whereHas('pembelian', function($q) use($value1, $value2) { $q->whereBetween('tgl_beli', [$value1, $value2]); })->get();
        // }
        // else 
        // {
        //     $orders = $orders->get();
        // }
        // $total = 0;
        // $total1 = 0;
        // //JIKA DATA ADA
        // if (count($orders) > 0) {
        //     //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
        //     $sub = $orders->pluck('jmlh')->all();
        //     //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
        //     $total = array_sum($sub);
        // }
        // foreach ($orders as $order) {
        //     $total1 += $order->pembelian->hrg_total;
        // }
    }
    public function showLaporanPenjualanDetail(Request $request)
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik' || Auth::user()->role == 'manager' || Auth::user()->role == 'pegawai'))
        {
            //$orders = DetailPenjualanModel::with('penjualan')->whereHas('penjualan', function($q) { $q->where('aktif', '=', 1); })
            //        ->orderBy('created_at', 'DESC');
            $orders = PenjualanModel::with('detailpenjualans')->where('aktif', 1)->orderBy('tgl_jual', 'DESC');
            $pelanggans = PelangganModel::where('aktif', 1)->orderBy('nama', 'ASC')->get();
            $metodes = MetodeModel::where('aktif', 1)->get();
            $barangs = BarangModel::where('aktif', 1)->get();

            if (!empty($request->metode)) {
                $value = $request->metode;
                $order = $orders->where('metode_bayar', $request->metode);
                //$orders = $orders->whereHas('penjualan', function($q) use($value) { $q->where('metode_bayar', '=', $value); });
            }
            if (!empty($request->pelanggan)) {
                $value = $request->pelanggan;
                $order = $orders->where('pelanggan_id', $request->pelanggan);
                //$orders = $orders->whereHas('penjualan', function($q) use($value) { $q->where('pelanggan_id', '=', $value); });
            }
            if (!empty($request->barang)) {
                $value = $request->barang;
                $order = $orders->whereHas('detailpenjualans', function($q) use($value) { $q->where('kode_barang', $value); });
                //$orders = $orders->where('kode_barang', $request->barang);
            }
            if (!empty($request->start_date) && !empty($request->end_date))
            {
                $value1 = $request->start_date;
                $value2 = $request->end_date;
                $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';
                $order = $orders->whereBetween('tgl_jual', [$request->start_date, $request->end_date]);
                //$orders = $orders->whereHas('penjualan', function($q) use($value1, $value2) { $q->whereBetween('tgl_jual', [$value1, $value2]); })->get();
            }
            $orders = $orders->get();
            $total = 0;
            $total1 = 0;
            //JIKA DATA ADA
            if (count($orders) > 0) {
                //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
                $sub = $orders->pluck('jmlh')->all();
                //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
                $total = array_sum($sub);
            }
            foreach ($orders as $order) {
                $total1 += $order->hrg_total;
            }
            return view('admin/laporan/penjualan/laporanpenjualandetail', compact('orders', 'pelanggans', 'metodes', 'barangs', 'total', 'total1'));
        }
        else
            return redirect()->back();
    }

    public function showLaporanPenjualanMetode(Request $request)
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik' || Auth::user()->role == 'manager' || Auth::user()->role == 'pegawai'))
        {
            $orders = PenjualanModel::where('aktif', 1)->orderBy('tgl_jual', 'DESC');
            $metodes = MetodeModel::where('aktif', 1)->get();

            if (!empty($request->metode)) {
                $orders = $orders->where('metode_bayar', $request->metode);
            }
            if (!empty($request->start_date) && !empty($request->end_date))
            {
                $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';
                $orders = $orders->whereBetween('tgl_jual', [$start_date, $end_date]);
            }
            $orders = $orders->get();
            $total = 0;
            //JIKA DATA ADA
            if (count($orders) > 0) {
                //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
                $sub = $orders->pluck('hrg_total')->all();
                //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
                $total = array_sum($sub);
            }
            return view('admin/laporan/penjualan/laporanpenjualanmetode', compact('metodes', 'orders', 'total'));
        }
        else
            return redirect()->back();
    }
    public function showLaporanPenjualanPelanggan(Request $request)
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik' || Auth::user()->role == 'manager' || Auth::user()->role == 'pegawai'))
        {
            $orders = PenjualanModel::where('aktif', 1)->orderBy('tgl_jual', 'DESC');
            $pelanggans = PelangganModel::where('aktif', 1)->orderBy('nama', 'ASC')->get();

            if (!empty($request->pelanggan)) {
                $orders = $orders->where('pelanggan_id', $request->pelanggan);
            }
            if (!empty($request->start_date) && !empty($request->end_date))
            {
                $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';
                $orders = $orders->whereBetween('tgl_jual', [$start_date, $end_date]);
            }
            $orders = $orders->get();
            $total = 0;
            //JIKA DATA ADA
            if (count($orders) > 0) {
                //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
                $sub = $orders->pluck('hrg_total')->all();
                //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
                $total = array_sum($sub);
            }
            return view('admin/laporan/penjualan/laporanpenjualanpelanggan', compact('orders', 'pelanggans', 'total'));
        }
        else
            return redirect()->back();
    }

    public function showLaporanReturPembelianDetail(Request $request)
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik'))
        {
            $returs = DetailReturPembelianModel::with('returpembelian')->whereHas('returpembelian', function($q) { $q->where('aktif', '=', 1); })
                    ->orderBy('created_at', 'DESC');
            $orders = PembelianModel::where('aktif', 1)->get();
            $barangs = BarangModel::where('aktif', 1)->get();

            if (!empty($request->faktur)) {
                $value = $request->faktur;
                $returs = $returs->whereHas('returpembelian', function($q) use($value) { $q->where('faktur_pembelian', '=', $value); });
            }
            if (!empty($request->barang)) {
                $returs = $returs->where('kode_barang', $request->barang);
            }
            if (!empty($request->start_date) && !empty($request->end_date))
            {
                $value1 = $request->start_date;
                $value2 = $request->end_date;
                $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';
                $returs = $returs->whereHas('returpembelian', function($q) use($value1, $value2) { $q->whereBetween('tgl_retur', [$value1, $value2]); });
            }
            $returs = $returs->get();
            
            $total = 0;
            //JIKA DATA ADA
            if (count($returs) > 0) {
                //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
                $sub = $returs->pluck('subtotal')->all();
                //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
                $total = array_sum($sub);
            }
            return view('admin/laporan/returpembelian/laporanreturpembeliandetail', compact('orders', 'returs', 'barangs', 'total'));
        }
        else
            return redirect()->back();
    }
    public function showLaporanReturPenjualanDetail(Request $request)
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik' || Auth::user()->role == 'manager'))
        {
            $returs = DetailReturPenjualanModel::with('returpenjualan')->whereHas('returpenjualan', function($q) { $q->where('aktif', '=', 1); })
                    ->orderBy('created_at', 'DESC');
            $orders = PenjualanModel::where('aktif', 1)->get();
            $barangs = BarangModel::where('aktif', 1)->get();

            if (!empty($request->faktur)) {
                $value = $request->faktur;
                $returs = $returs->whereHas('returpenjualan', function($q) use($value) { $q->where('faktur_penjualan', '=', $value); });
            }
            if (!empty($request->barang)) {
                $returs = $returs->where('kode_barang', $request->barang);
            }
            if (!empty($request->start_date) && !empty($request->end_date))
            {
                $value1 = $request->start_date;
                $value2 = $request->end_date;
                $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';
                $returs = $returs->whereHas('returpenjualan', function($q) use($value1, $value2) { $q->whereBetween('tgl_retur', [$value1, $value2]); });
            }
            $returs = $returs->get();
            
            $total = 0;
            //JIKA DATA ADA
            if (count($returs) > 0) {
                //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
                $sub = $returs->pluck('subtotal')->all();
                //KEMUDIAN DATA YANG ADA DIDALAM ARRAY DIJUMLAHKAN
                $total = array_sum($sub);
            }
            return view('admin/laporan/returpenjualan/laporanreturpenjualandetail', compact('orders', 'returs', 'barangs', 'total'));
        }
        else
            return redirect()->back();  
    }

    public function invoicePdf($invoice)
    {
        //MENGAMBIL DATA TRANSAKSI BERDASARKAN INVOICE
        $order = PenjualanModel::where('no_faktur', $invoice)
                ->with('pelanggan', 'detailpenjualans', 'detailpenjualans.barang')->first();
        //SET CONFIG PDF MENGGUNAKAN FONT SANS-SERIF
        //DENGAN ME-LOAD VIEW INVOICE.BLADE.PHP
        $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->loadView('admin/laporan/penjualan/invoice', compact('order'));
        return $pdf->stream();
    }
    public function invoiceExcel($invoice)
    {
        return (new OrderInvoice($invoice))->download('invoice-' . $invoice . '.xlsx');
    }
    public function showLaporanPembelian($id)
    {
        $data = PembelianModel::where('no_faktur', $id)->first();
        $details = DetailPembelianModel::where('faktur_pembelian', $id)->get();
        return view('admin/returpembelian/print', compact('data', 'details'));
    }
    public function showLaporanReturPembelian($id)
    {
        $data = PembelianModel::where('no_faktur', $id)->first();
        $details = DetailPembelianModel::where('faktur_pembelian', $id)->get();
        return view('admin/returpembelian/print', compact('data', 'details'));
    }
}
