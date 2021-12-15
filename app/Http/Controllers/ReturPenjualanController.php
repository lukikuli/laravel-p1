<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\ReturPenjualanModel;
use App\DetailReturPenjualanModel;
use App\PenjualanModel;
use App\DetailPenjualanModel;
use App\PelangganModel;
use App\BarangModel;
use App\NotifModel;
use DB;

class ReturPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik' || Auth::user()->role == 'manager' || Auth::user()->role == 'pegawai'))
        {
            $datas = ReturPenjualanModel::where('aktif', 1)->orderBy('created_at', 'DESC')->with('penjualan')->get();
            return view('admin/returpenjualan/index', compact('datas'));
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
        $pelanggans = PelangganModel::where('aktif', 1)->get();
        $penjualans = PenjualanModel::where('aktif', 1)->get();
        $kode = ReturPenjualanModel::getKodeReturPenjualan();
        return view('admin/returpenjualan/create', compact('penjualans', 'kode', 'pelanggans'));
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
            'no_faktur' => 'required',
            'ket' => 'required'
        ]);
        if(!is_null($request->kode_barang) || !empty($request->kode_barang))
        {
            DB::transaction(function() use($request) {
                $kodes = $request->kode_barang;
                $data = new ReturPenjualanModel();
                $data->no_retur = $request->kode;
                $data->tgl_retur = $request->tgl_retur;
                $data->hrg_total = $request->total;
                $data->faktur_penjualan = $request->no_faktur;
                $data->keterangan = $request->ket;
                $data->creator = Auth::user()->id;
                $data->aktif = 1;
                $data->save();

                foreach ($kodes as $key =>$kode) {
                    if(!is_null($request->jmlh_retur[$key]) || !is_empty($request->jmlh_retur[$Key]))
                    {
                        $detail = new DetailReturPenjualanModel();
                        $detail->retur_penjualan = $request->kode;
                        $detail->kode_barang = $request->kode_barang[$key];
                        $detail->harga_barang = $request->harga_barang[$key];
                        $detail->jmlh_retur = $request->jmlh_retur[$key];
                        //$detail->jmlh_ganti = $request->jmlh_ganti[$key];
                        $detail->creator = Auth::user()->id;
                        $detail->subtotal = $request->subtotal[$key];
                        $detail->save();

                        $barang = BarangModel::where('kode', $request->kode_barang[$key])->first();
                        $barang->stok = (int)$barang->stok - (int)$request->jmlh_retur[$key];
                        $barang->save();
                        if($barang->stok <= $barang->stok_min)
                        {
                            $notif = NotifModel::where('kode_barang', $barang->kode)->first();
                            if($notif != null) $notif->delete();
                            $notif = new NotifModel();
                            $notif->pesan = 'Stok '.$barang->nama.' ('.$barang->kode.') TERSISA '.$barang->stok.'.';
                            $notif->kode_barang = $barang->kode;
                            $notif->creator = Auth::user()->id;
                            $notif->aktif = 1;
                            $notif->save();
                        }
                    }
                }
            });
            return redirect()->route('returpenjualan.index')->with('alert-success', 'Berhasil menambahkan data!');
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
        $data = ReturPenjualanModel::where('no_retur', $id)->first();
        $details = DetailReturPenjualanModel::where('retur_penjualan', $id)->get();
        return view('admin/returpenjualan/show', compact('data', 'details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function print($id)
    {
        $id = decrypt($id);
        $data = ReturPenjualanModel::where('no_retur', $id)->first();
        $details = DetailReturPenjualanModel::where('retur_penjualan', $id)->get();
        return view('admin/returpenjualan/print', compact('data', 'details'));
    }
}
