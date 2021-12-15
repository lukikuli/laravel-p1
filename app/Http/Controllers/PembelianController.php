<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\PembelianModel;
use App\DetailPembelianModel;
use App\SupplierModel;
use App\BarangModel;
use App\NotifModel;
use DB;

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik' || Auth::user()->role == 'manager'))
        {
            $datas = PembelianModel::where('aktif', 1)->orderBy('created_at', 'DESC')->with('supplier')->get();
            return view('admin/pembelian/index', compact('datas'));
        }
        else
            return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = SupplierModel::where('aktif', 1)->get();
        $kode = PembelianModel::getKodePembelian();
        $barangs = BarangModel::where('aktif', 1)->get();
        return view('admin/pembelian/create', compact('suppliers', 'kode', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'supplier' => 'required',
            'keterangan' => 'required'
        ]);
        if(!is_null($request->kode_barang) || !empty($request->kode_barang))
        {
            DB::transaction(function() use($request) {
                $kodes = $request->kode_barang;
                $data = new PembelianModel();
                $data->no_faktur = $request->kode;
                $data->tgl_beli = $request->tgl_beli;
                $data->hrg_total = $request->hrg_total;
                $data->supplier_id = $request->supplier;
                $data->keterangan = $request->ket;
                $data->creator = Auth::user()->id;
                $data->aktif = 1;
                $data->save();

                foreach ($kodes as $key =>$kode) {
                    $detail = new DetailPembelianModel();
                    $detail->faktur_pembelian = $request->kode;
                    $detail->kode_barang = $request->kode_barang[$key];
                    $detail->harga_barang = $request->harga_barang[$key];
                    $detail->jmlh = $request->jmlh[$key];
                    $detail->creator = Auth::user()->id;
                    $detail->subtotal = $request->subtotal[$key];
                    $detail->save();

                    $barang = BarangModel::where('kode', $request->kode_barang[$key])->where('aktif', 1)->first();
                    $barang->stok = (int)$barang->stok + (int)$request->jmlh[$key];
                    $barang->save();
                    $notif = NotifModel::where('kode_barang', $barang->kode)->first();
                    if($notif != null) $notif->delete();
                    if($barang->stok <= $barang->stok_min)
                    {
                        $notif = new NotifModel();
                        $notif->pesan = 'Stok '.$barang->nama.' ('.$barang->kode.') TERSISA '.$barang->stok.'.';
                        $notif->kode_barang = $barang->kode;
                        $notif->creator = Auth::user()->id;
                        $notif->aktif = 1;
                        $notif->save();
                    }
                }
            });
            return redirect()->route('pembelian.index')->with('alert-success', 'Berhasil menambahkan data!');
        }
        else
        {
            //$validatedData = false;
            return redirect()->back()->withErrors(['tabel' => 'Tidak ada barang yang dipilih'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = decrypt($id);
        $data = PembelianModel::where('no_faktur', $id)->first();
        $details = DetailPembelianModel::where('faktur_pembelian', $id)->get();
        return view('admin/pembelian/show', compact('data', 'details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suppliers = SupplierModel::where('aktif', 1)->get();
        $data = PembelianModel::where('no_faktur', $id)->first();
        $details = DetailPembelianModel::where('faktur_pembelian', $id)->get();
        return view('admin/pembelian/edit', compact('suppliers', 'data', 'details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'supplier' => 'required'
        ]);
        DB::transaction(function() use($request) {
            $data = PembelianModel::where('no_faktur', $id)->first();
            $data->tgl_beli = $request->tgl_beli;
            $data->hrg_total = $request->hrg_total;
            $data->supplier_id = $request->supplier;
            $data->modifier = Auth::user()->id;
            $data->aktif = 1;
            $data->save();

            $kodes = $request->kode_barang;
            foreach ($kodes as $key =>$kode) {
                $detail = DetailPembelianModel::where('id', $request->id[$key])->first();
                $detail->faktur_pembelian = $request->kode;
                $detail->kode_barang = $request->kode_barang[$key];
                $detail->harga_barang = $request->harga_barang[$key];
                $detail->jmlh = $request->jmlh[$key];
                $detail->modifier = Auth::user()->id;
                $detail->subtotal = $request->subtotal[$key];
                $detail->save();
                $barang = BarangModel::where('kode_barang', $request->kode_barang[$key])->first();
                $barang->stok = (int)$barang->stok + (int)$request->jmlh[$key];
                $barang->save();
            }
            return redirect()->route('pembelian.index')->with('alert-success', 'Data berhasil diubah!');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $data = PembelianModel::where('no_faktur', $id)->first();
        $data->aktif = 0;
        $data->modifier = Session::get('userid');
        $data->save();
        return redirect()->route('supplier.index')->with('alert-success', 'Data berhasil dihapus!');
    }
    public function printfaktur($id)
    {
        $id = decrypt($id);
        $data = PembelianModel::where('no_faktur', $id)->first();
        $details = DetailPembelianModel::where('faktur_pembelian', $id)->get();
        return view('admin/pembelian/printfaktur', compact('data', 'details'));
    }
}
