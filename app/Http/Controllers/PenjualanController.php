<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\PenjualanModel;
use App\DetailPenjualanModel;
use App\PelangganModel;
use App\MetodeModel;
use App\BarangModel;
use App\NotifModel;
use DB;
use Input;

use Mike42\Escpos\Printer; 
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class PenjualanController extends Controller
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
        if (Auth::check() &&(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik' || Auth::user()->role == 'manager' || Auth::user()->role == 'pegawai'))
        {
            $datas = PenjualanModel::where('aktif', 1)->orderBy('no_faktur', 'DESC')->with('pelanggan')->get();
            return view('admin/penjualan/index', compact('datas'));
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
        $metodes = MetodeModel::where('aktif', 1)->get();
        $kode = PenjualanModel::getKodePenjualan();
        $barangs = BarangModel::where('aktif', 1)->get();
        return view('admin/penjualan/create', compact('pelanggans', 'kode', 'metodes', 'barangs'));
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
            'bayar' => 'required|numeric',
            'metode_bayar' => 'required',
            'pelanggan' => 'required'
        ]);
        if(!is_null($request->kode_barang) || !empty($request->kode_barang))
        {
            DB::transaction(function() use($request) {

                $datas = [];
                $kodes = $request->kode_barang;
                $diskon = 0;
                foreach ($kodes as $key =>$kode)
                {
                    $diskon += ((float)$request->harga_barang[$key]*(float)$request->jmlh[$key]);
                }

                $data = new PenjualanModel();
                //$data->no_faktur = PenjualanModel::getKodePenjualan();
                //$data->tgl_jual = date("Y-m-d H:i:s");
                $data->no_faktur = $request->kode;
                $data->tgl_jual = $request->tgl_jual;
                $data->pelanggan_id = $request->pelanggan;
                $data->hrg_total = $request->hrg_total;
                $data->diskon_total = (float)$diskon-(float)$request->hrg_total;
                $data->metode_bayar = $request->metode_bayar;
                $data->bayar = $request->bayar;
                $data->kembali = $request->kembali;
                $data->creator = Auth::user()->id;
                $data->aktif = 1;
                $data->save();

                foreach ($kodes as $key =>$kode) {
                    $detail = new DetailPenjualanModel();
                    $detail->faktur_penjualan = $request->kode;
                    $detail->kode_barang = $request->kode_barang[$key];
                    $detail->diskon_harga = $request->diskon_harga[$key];
                    $detail->diskon_persen = $request->diskon_persen[$key];
                    $detail->jmlh = $request->jmlh[$key];
                    $detail->harga_barang = $request->harga_barang[$key];
                    $detail->harga_barang_diskon = $request->harga_barang_diskon[$key];
                    $detail->subtotal = $request->subtotal[$key];
                    $detail->creator = Auth::user()->id;
                    $detail->save();

                    $barang = BarangModel::where('kode', $request->kode_barang[$key])->first();
                    $barang->stok = (int)$barang->stok - (int)$request->jmlh[$key];
                    $barang->save();
                    $datas[] = [
                        'faktur_penjualan' => $request->kode,
                        'kode_barang' => $request->kode_barang[$key],
                        'diskon_harga' => $request->diskon_harga[$key],
                        'diskon_persen' => $request->diskon_persen[$key],
                        'jmlh' => $request->jmlh[$key],
                        'harga_barang' => $request->harga_barang[$key],
                        'harga_barang_diskon' => $request->harga_barang_diskon[$key],
                        'subtotal' => $request->subtotal[$key],
                    ];
                }
                //DetailPenjualanModel::insert($datas);
            });
            
            $data = PenjualanModel::where('no_faktur', $request->kode)->first();
            $details = DetailPenjualanModel::where('faktur_penjualan', $data->no_faktur)->get();
            return view('admin/penjualan/printfaktur', compact('data', 'details'));
            //return redirect()->route('penjualan.index')->with('alert-success', 'Berhasil menambahkan data!');
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
        $data = PenjualanModel::where('no_faktur', $id)->first();
        $details = DetailPenjualanModel::where('faktur_penjualan', $id)->get();
        return view('admin/penjualan/show', compact('data', 'details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PenjualanModel::where('no_faktur', $id)->first();
        return view('admin/penjualan/edit', compact('data'));
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
            'bayar' => 'required|numeric',
            'metode_bayar' => 'required',
            'pelanggan' => 'required'
        ]);
        DB::transaction(function() use($request) {
            $data = PenjualanModel::where('no_faktur', $id)->first();
            $data->tgl_jual = $request->tgl_jual;
            $data->pelanggan_id = $request->pelanggan;
            $data->hrg_total = $request->hrg_total;
            $data->diskon_total = $request->diskon_total;
            $data->metode_bayar = $request->metode_bayar;
            $data->bayar = $request->bayar;
            $data->kembali = $request->kembali;
            $data->modifier = Auth::user()->id;
            $data->aktif = 1;
            $data->save();

            $kodes = $request->kode_barang;
            foreach ($kodes as $key =>$kode) {
                $detail = new DetailPenjualanModel();
                $detail->faktur_penjualan = $request->kode;
                $detail->kode_barang = $request->kode_barang[$key];
                $detail->diskon_harga = $request->diskon_harga[$key];
                $detail->diskon_persen = $request->diskon_persen[$key];
                $detail->jmlh = $request->jmlh[$key];
                $detail->harga_barang = $request->harga_barang[$key];
                $detail->harga_barang_diskon = $request->harga_barang_iskon[$key];
                $detail->subtotal = $request->subtotal[$key];
                $detail->modifier = Auth::user()->id;
                $detail->save();
            }
        });
        return redirect()->route('penjualan.index')->with('alert-success', 'Data berhasil diubah!');
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
        $data = PenjualanModel::where('no_faktur', $id)->first();
        $data->aktif = 0;
        $data->modifier = Session::get('userid');
        $data->save();
        return redirect()->route('supplier.index')->with('alert-success', 'Data berhasil dihapus!');
    }

    public function savePenjualanAjax(Request $request)
    {
        $check = false;
        $validatedData = $request->validate([
            'bayar' => 'required',
            'metode_bayar' => 'required',
            'pelanggan' => 'required'
        ]);
        if(!is_null($request->kode_barang) || !empty($request->kode_barang))
        {
            DB::transaction(function() use($request) {
                $kodes = $request->kode_barang;
                $diskon = 0;
                foreach ($kodes as $key =>$kode)
                {
                    $harga = str_replace('.', '', $request->harga_barang[$key]);
                    $jmlh = str_replace('.', '', $request->jmlh[$key]);
                    $diskon += ((float)$harga*(float)$jmlh);
                }

                $data = new PenjualanModel();
                //$data->no_faktur = PenjualanModel::getKodePenjualan();
                //$data->tgl_jual = date("Y-m-d H:i:s");
                $data->no_faktur = $request->kode;
                $data->tgl_jual = $request->tgl_jual;
                $data->pelanggan_id = $request->pelanggan;
                $data->hrg_total = str_replace('.', '', $request->hrg_total);
                $data->diskon_total = (float)$diskon-(float)str_replace('.', '', $request->hrg_total);
                $data->metode_bayar = $request->metode_bayar;
                $data->bayar = str_replace('.', '', $request->bayar);
                $data->kembali = str_replace('.', '', $request->kembali);
                $data->creator = Auth::user()->id;
                $data->aktif = 1;
                $data->save();

                foreach ($kodes as $key =>$kode) {
                    $detail = new DetailPenjualanModel();
                    $detail->faktur_penjualan = $request->kode;
                    $detail->kode_barang = $request->kode_barang[$key];
                    if(isset($request->diskon_harga[$key]))
                        $detail->diskon_harga = str_replace('.', '', $request->diskon_harga[$key]);
                    //$detail->diskon_persen = $request->diskon_persen[$key];
                    if(isset($request->harga_extra[$key]))
                        $detail->harga_extra = str_replace('.', '', $request->harga_extra[$key]);
                    if(isset($request->jmlh[$key]))
                        $detail->jmlh = str_replace('.', '', $request->jmlh[$key]);
                    if(isset($request->harga_barang[$key]))
                        $detail->harga_barang = str_replace('.', '', $request->harga_barang[$key]);
                    if(isset($request->harga_barang_diskon[$key]))
                        $detail->harga_barang_diskon = str_replace('.', '', $request->harga_barang_diskon[$key]);
                    if(isset($request->subtotal[$key]))
                        $detail->subtotal = str_replace('.', '', $request->subtotal[$key]);
                    $detail->creator = Auth::user()->id;
                    $detail->save();

                    $barang = BarangModel::where('kode', $request->kode_barang[$key])->first();
                    $barang->stok = (int)$barang->stok - (int)str_replace('.', '', $request->jmlh[$key]);
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
            $result = [
                    'success' => true,
                    'msg' => 'Transaksi behasil!',
                    'id' => encrypt($request->kode)
            ];
        }
        else
        {
            $result = [
                    'success' => false,
                    'msg' => 'Tidak ada barang yang dipilih',
                    'id' => ''
            ];
        }
        return response()->json($result);
    }

    public function printthermal($id)
    {
        $id = decrypt($id);
        $data = PenjualanModel::where('no_faktur', $id)->first();
        $details = DetailPenjualanModel::where('faktur_penjualan', $id)->get();
        return view('admin/penjualan/printthermal', compact('data', 'details'));
    }
    public function printfaktur($id)
    {
        $id = decrypt($id);
        $data = PenjualanModel::where('no_faktur', $id)->first();
        $details = DetailPenjualanModel::where('faktur_penjualan', $id)->get();
        return view('admin/penjualan/printfaktur', compact('data', 'details'));
    }
    public function printsuratjalan($id)
    {
        $id = decrypt($id);
        $data = PenjualanModel::where('no_faktur', $id)->first();
        $details = DetailPenjualanModel::where('faktur_penjualan', $id)->get();
        return view('admin/penjualan/printsuratjalan', compact('data', 'details'));
    }

    public function printThermalAuto($id)
    {
        $id = decrypt($id);
        $data = PenjualanModel::where('no_faktur', $id)->first();
        $details = DetailPenjualanModel::where('faktur_penjualan', $id)->get();

        $date = date('l jS \of F Y h:i:s A');
        try {
            $connector = new WindowsPrintConnector("POS-58");
            $printer = new Escpos($connector);
            $printer -> text("Hello World!\n");

            /* Name of shop */
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer -> text("DRAGON KOI CENTER\n");
            $printer -> selectPrintMode();
            $printer -> text($date.\n);
            $printer -> feed();

            /* Tax and total */
            $printer -> text("Rp ".number_format($data->hrg_total));
            $printer -> text("Rp ".number_format($data->bayar));
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer -> text("Rp ".number_format($data->kembali));
            $printer -> selectPrintMode();

            /* Footer */
            $printer -> feed(2);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("Terima Kasih\n");
            $printer -> text(" Green Ville Blok L no. 1. Jakarta Barat 11510\nTelp : 021-5674758/59. Fax  : 021-5686564\n");
            $printer -> feed(2);

            /* Cut the receipt */
            $printer -> cut();
            $printer -> close();
        } catch(Exception $e) {
            return redirect()->back()->withErrors(['alert-danger' => 'Tidak bisa print dengan ini']);
            //echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }
}
