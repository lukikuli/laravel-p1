<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\MetodeModel;

class MetodeController extends Controller
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
            $datas = MetodeModel::where('aktif', 1)->orderBy('id', 'DESC')->get();
            return view('admin/metodebayar/index', compact('datas'));
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
        return view('admin/metodebayar/create');
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
            'metode' => 'required'
        ]);
        $data = new MetodeModel();
        $data->nama_metode = $request->metode;
        $data->creator = Auth::user()->id;
        $data->aktif = 1;
        $data->save();
        return redirect()->route('metodebayar.index')->with('alert-success', 'Berhasil menambahkan data!');
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
        $data = MetodeModel::findOrFail($id);
        return view('admin/metodebayar/show', compact('data'));
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
        $data = MetodeModel::findOrFail($id);
        return view('admin/metodebayar/edit', compact('data'));
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
            'metode' => 'required'
        ]);
        $data = MetodeModel::find($id);
        $data->nama_metode = $request->metode;
        $data->modifier = Auth::user()->id;
        $data->aktif = 1;
        $data->save();
        return redirect()->route('metodebayar.index')->with('alert-success', 'Berhasil menambahkan data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = MetodeModel::find($id);
        $data->aktif = 0;
        $data->modifier = Session::get('userid');
        $data->save();
        return redirect()->route('metodebayar.index')->with('alert-success', 'Data berhasil dihapus!');
    }
}
