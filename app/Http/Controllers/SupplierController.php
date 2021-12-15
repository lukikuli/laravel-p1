<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\SupplierModel;

class SupplierController extends Controller
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
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik'))
        {
            $datas = SupplierModel::where('aktif', 1)->orderBy('id', 'DESC')->get();
            return view('admin/supplier/index', compact('datas'));
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
        return view('admin/supplier/create');
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
            'alamat' => 'required',
            'kota' => 'required',
            'telp1' => 'required|max:20'
        ]);
        $data = new SupplierModel();
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->kota = $request->kota;
        $data->telp_1 = $request->telp1;
        $data->telp_2 = $request->telp2;
        $data->keterangan = $request->keterangan;
        $data->creator = Auth::user()->id;
        $data->aktif = 1;
        $data->save();
        return redirect()->route('supplier.index')->with('alert-success', 'Berhasil menambahkan data!');
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
        $data = SupplierModel::find($id);
        return view('admin/supplier/show', compact('data'));
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
        $data = SupplierModel::find($id);
        return view('admin/supplier/edit', compact('data'));
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
            'alamat' => 'required',
            'kota' => 'required',
            'telp1' => 'required|max:20'
        ]);
        $data = SupplierModel::find($id);
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->kota = $request->kota;
        $data->telp_1 = $request->telp1;
        $data->telp_2 = $request->telp2;
        $data->keterangan = $request->keterangan;
        $data->modifier = Auth::user()->id;
        $data->aktif = 1;
        $data->save();
        return redirect()->route('supplier.index')->with('alert-success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = SupplierModel::find($id);
        $data->aktif = 0;
        $data->modifier = Session::get('userid');
        $data->save();
        return redirect()->route('supplier.index')->with('alert-success', 'Data berhasil dihapus!');

    }
}
