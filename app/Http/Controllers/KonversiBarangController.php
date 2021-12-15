<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\KonversiBarangModel;
use App\BarangModel;
use App\JenisBarangModel;
use App\NotifModel;
use DB;

class KonversiBarangController extends Controller
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
            $datas = KonversiBarangModel::where('aktif', 1)->orderBy('created_at', 'DESC')->with('barangmasuk')->with('barangkeluar')->get();
            return view('admin/konversi/index', compact('datas'));
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
        $barangs = BarangModel::where('aktif', 1)->get();
        return view('admin/konversi/create', compact('barangs', 'jenisbarangs'));
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
            'jenis1' => 'required',
            'jenis2' => 'required',
            'barang1' => 'required',
            'barang2' => 'required',
            'stok_keluar' => 'required',
            'stok_masuk' => 'required'
        ]);
        $barang1 = BarangModel::where('kode', $request->barang1)->first();
        if($request->stok_keluar <= $barang1->stok)
        {
            DB::transaction(function() use($request) {
                $data = new KonversiBarangModel();
                $data->stok_keluar = $request->stok_keluar;
                $data->stok_masuk = $request->stok_masuk;
                $data->kode_barang_keluar = $request->barang1;
                $data->kode_barang_masuk = $request->barang2;
                $data->tgl_konversi = $request->tgl_konversi;
                $data->creator = Auth::user()->id;
                $data->aktif = 1;
                $data->save();

                $barang1 = BarangModel::where('kode', $request->barang1)->first();
                $barang1->stok = (int)$barang1->stok - (int)$request->stok_keluar;
                $barang1->save();
                $barang2 = BarangModel::where('kode', $request->barang2)->first();
                $barang2->stok = (int)$barang2->stok + (int)$request->stok_masuk;
                $barang2->save();
                
                $notif = NotifModel::where('kode_barang', $barang1->kode)->first();
                if($notif != null) $notif->delete();
                $notif = NotifModel::where('kode_barang', $barang2->kode)->first();
                if($notif != null) $notif->delete();
                if($barang1->stok <= $barang1->stok_min)
                {
                    $notif = new NotifModel();
                    $notif->pesan = 'Stok '.$barang1->nama.' ('.$barang1->kode.') TERSISA '.$barang1->stok.'.';
                    $notif->kode_barang = $barang1->kode;
                    $notif->creator = Auth::user()->id;
                    $notif->aktif = 1;
                    $notif->save();
                }
                if($barang2->stok <= $barang2->stok_min)
                {
                    $notif = new NotifModel();
                    $notif->pesan = 'Stok '.$barang2->nama.' ('.$barang2->kode.') TERSISA '.$barang2->stok.'.';
                    $notif->kode_barang = $barang2->kode;
                    $notif->creator = Auth::user()->id;
                    $notif->aktif = 1;
                    $notif->save();
                }
            });

            return redirect()->route('konversi.index')->with('alert-success', 'Berhasil menambahkan data!');
        }
        else
        {
            //$validatedData = false;
            return redirect()->back()->withErrors(['stok_keluar' => 'Stok barang yang dikeluarkan tidak mencukupi'])->withInput();
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
        $data = KonversiBarangModel::where('id', $id)->first();
        $jenisbarangs = JenisBarangModel::where('aktif', 1)->get();
        $barangs = BarangModel::where('aktif', 1)->get();
        return view('admin/konversi/show', compact('data', 'barangs', 'jenisbarangs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = KonversiBarangModel::where('id', $id)->first();
        $jenisbarangs = JenisBarangModel::where('aktif', 1)->get();
        $barangs = BarangModel::where('aktif', 1)->get();
        return view('admin/konversi/edit', compact('data', 'barangs', 'jenisbarangs'));
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
            'jenis1' => 'required',
            'jenis2' => 'required',
            'barang1' => 'required',
            'barang2' => 'required',
            'stok_keluar' => 'required',
            'stok_masuk' => 'required'
        ]);
        DB::transaction(function() use($request) {
            $data = KonversiBarangModel::where('id', $id)->first();
            $data->stok_keluar = $request->stok_keluar;
            $data->stok_masuk = $request->stok_masuk;
            $data->kode_barang_keluar = $request->barang1;
            $data->kode_barang_masuk = $request->barang2;
            $data->tgl_konversi = $request->tgl_konversi;
            $data->modifier = Auth::user()->id;
            $data->aktif = 1;
            $data->save();

            $barang1 = BarangModel::where('kode', $request->barang1)->first();
            $barang1->stok = (int)$barang1->stok - (int)$request->stok_keluar;
            $barang1->save();
            $barang2 = BarangModel::where('kode', $request->barang2)->first();
            $barang2->stok = (int)$barang2->stok + (int)$request->stok_masuk;
            $barang2->save();
        });
        return redirect()->route('konversi.index')->with('alert-success', 'Data berhasil diubah!');
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
}
