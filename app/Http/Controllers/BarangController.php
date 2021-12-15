<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\BarangModel;
use App\JenisBarangModel;
use App\NotifModel;
use App\SatuanModel;

class BarangController extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function __construct()

    {

         $this->middleware('permission:product-list');

         $this->middleware('permission:product-create', ['only' => ['create','store']]);

         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);

         $this->middleware('permission:product-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik'))
        {
            $datas = BarangModel::where('aktif', 1)->orderBy('kode', 'DESC')->with('satuan')->with('jenisbarang')->get();
            return view('admin/barang/index', compact('datas'));
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
        $jenisbarangs = JenisBarangModel::where('aktif', 1)->get();
        $satuans = SatuanModel::where('aktif', 1)->get();
        $kode = BarangModel::getKodeBarang();
        return view('admin/barang/create', compact('jenisbarangs', 'satuans', 'kode'));
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
            'nama' => 'required',
            'stok' => 'numeric',
            'stokmin' => 'numeric',
            'jual' => 'required|numeric',
            'beli' => 'required|numeric',
            'jenis' => 'required',
            'satuan' => 'required'
        ]);
        $beli = str_replace('.', '', $request->beli);
        $beli = str_replace(',', '.', $beli);
        $beli = ceil($beli);
        $jual = str_replace('.', '', $request->jual);
        $jual = str_replace(',', '.', $jual);
        $jual = ceil($jual);
        $data = new BarangModel();
        $data->kode = BarangModel::getKodeBarang();
        $data->barcode = $request->barcode;
        $data->nama = $request->nama;
        $data->stok = $request->stok;
        $data->stok_min = $request->stokmin;
        $data->harga_jual = $jual;
        $data->harga_beli = $beli;
        $data->creator = Auth::user()->id;
        $data->jenis_id = $request->jenis;
        $data->satuan_id = $request->satuan;
        $data->keterangan = $request->keterangan;
        $data->aktif = 1;
        $data->save();

        $barang = BarangModel::where('kode', $data->kode)->first();
        $notif = NotifModel::where('kode_barang', $barang->kode)->first();
        if($notif != null) 
            $notif->delete();
        if($barang->stok <= $barang->stok_min)
        {
            $notif = new NotifModel();
            $notif->pesan = 'Stok '.$barang->nama.' ('.$barang->kode.') TERSISA '.$barang->stok.'.';
            $notif->kode_barang = $barang->kode;
            $notif->creator = Auth::user()->id;
            $notif->aktif = 1;
            $notif->save();
        }
        return redirect()->route('barang.index')->with('alert-success', 'Berhasil menambahkan data!');
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
        $data = BarangModel::where('kode', $id)->first();
        return view('admin/barang/show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $data = BarangModel::where('kode', $id)->first();
        $jenisbarangs = JenisBarangModel::where('aktif', 1)->get();
        $satuans = SatuanModel::where('aktif', 1)->get();
        return view('admin/barang/edit', compact('data', 'jenisbarangs', 'satuans'));
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
            'nama' => 'required',
            'stok' => 'numeric',
            'stokmin' => 'numeric',
            'jual' => 'required',
            'beli' => 'required',
            'jenis' => 'required',
            'satuan' => 'required'
        ]);
        $beli = str_replace('.', '', $request->beli);
        $beli = str_replace(',', '.', $beli);
        $beli = ceil($beli);
        $jual = str_replace('.', '', $request->jual);
        $jual = str_replace(',', '.', $jual);
        $jual = ceil($jual);
        $data = BarangModel::where('kode', $id)->first();
        $data->barcode = $request->barcode;
        $data->nama = $request->nama;
        $data->stok = $request->stok;
        $data->stok_min = $request->stokmin;
        $data->harga_jual = $jual;
        $data->harga_beli = $beli;
        $data->modifier = Auth::user()->id;
        $data->jenis_id = $request->jenis;
        $data->satuan_id = $request->satuan;
        $data->keterangan = $request->keterangan;
        $data->aktif = 1;
        $data->save();

        $barang = BarangModel::where('kode', $id)->first();
        $notif = NotifModel::where('kode_barang', $barang->kode)->first();
        if($notif != null) 
            $notif->delete();
        if($barang->stok <= $barang->stok_min)
        {
            $notif = new NotifModel();
            $notif->pesan = 'Stok '.$barang->nama.' ('.$barang->kode.') TERSISA '.$barang->stok.'.';
            $notif->kode_barang = $barang->kode;
            $notif->creator = Auth::user()->id;
            $notif->aktif = 1;
            $notif->save();
        }

        return redirect()->route('barang.index')->with('alert-success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = BarangModel::where('kode', $id)->first();
        $data->aktif = 0;
        $data->modifier = Session::get('userid');
        $data->save();
        return redirect()->route('barang.index')->with('alert-success', 'Data berhasil dihapus!');
    }

}
