<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\SatuanModel;

class SatuanController extends Controller
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
            $datas = SatuanModel::where('aktif', 1)->orderBy('id', 'DESC')->get();
            return view('admin/satuanbarang/index', compact('datas'));
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
        return view('admin/satuanbarang/create');
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
            'nama' => 'required'
        ]);
        $data = new SatuanModel();
        $data->nama_satuan = $request->nama;
        $data->aktif = 1;
        $data->creator = Auth::user()->id;
        $data->save();
        return redirect()->route('satuanbarang.index')->with('alert-success', 'Berhasil menambahkan data!');
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
        $data = SatuanModel::find($id);
        return view('admin/satuanbarang/show', compact('data'));
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
        $data = SatuanModel::find($id);
        return view('admin/satuanbarang/edit', compact('data'));
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
            'nama' => 'required'
        ]);
        $data = SatuanModel::find($id);
        $data->nama_satuan = $request->nama;
        $data->aktif = 1;
        $data->modifier = Auth::user()->id;
        $data->save();
        return redirect()->route('satuanbarang.index')->with('alert-success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = SatuanModel::find($id);
        $data->aktif = 0;
        $data->modifier = Session::get('userid');
        $data->save();
        return redirect()->route('satuanbarang.index')->with('alert-success', 'Data berhasil dihapus!');

    }
}
