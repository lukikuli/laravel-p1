<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/	

Auth::routes(['register' => false]);
Route::get('logout', function(){
     return back();
});

Route::name('home')->get('/home', 'HomeController@index');
Route::name('home')->get('/', 'HomeController@index');
Route::name('admin')->get('/admin', 'HomeController@index');

Route::post('/getAjaxBarang', 'AjaxController@getAjaxBarkodeBarang');
Route::post('/getAJaxKodeBarang', 'AjaxController@getAjaxBarangbyKode');
Route::post('/getAjaxJenisBrg', 'AjaxController@getAjaxBarangbyJenis');
Route::post('/getAjaxNamaBarang', 'AjaxController@getAjaxNamaBarang');
Route::post('/getAjaxPelanggan', 'AjaxController@getAjaxPelanggan');
Route::post('/getAjaxPembelian', 'AjaxController@getAjaxPembelian');
Route::post('/getAjaxPenjualan', 'AjaxController@getAjaxPenjualan');
Route::post('/getAjaxPenjualanPelanggan', 'AjaxController@getAjaxPenjualanByPelanggan');
Route::post('/getAjaxPembelianSupplier', 'AjaxController@getAjaxPembelianBySupplier');
Route::post('/getAjaxSupplier', 'AjaxController@getAjaxSupplier');
Route::get('/ceknotif', 'AjaxController@cekNotifikasi');
Route::post('/getPenjualanChart1', 'AjaxController@getPenjualanChart1');
Route::post('/getPenjualanChart2', 'AjaxController@getPenjualanChart2');

Route::name('laporanstokbarang')->get('admin/laporan/stokbarang', 'LaporanController@showLaporanStokBarang');
Route::name('laporankonversibarang')->get('admin/laporan/konversibarang', 'LaporanController@showLaporanKonversiBarang');
Route::name('laporanpembelian.supplier')->get('admin/laporan/pembeliansupplier', 'LaporanController@showLaporanPembelianSupplier');
Route::name('laporanpembelian.supplier')->get('admin/laporan/pembeliansupplier', 'LaporanController@showLaporanPembelianSupplier');
Route::name('laporanpembelian.detail')->get('admin/laporan/pembeliandetail', 'LaporanController@showLaporanPembelianDetail');
Route::name('laporanpenjualan.metode')->get('admin/laporan/penjualanmetode', 'LaporanController@showLaporanPenjualanMetode');
Route::name('laporanpenjualan.pelanggan')->get('admin/laporan/penjualanpelanggan', 'LaporanController@showLaporanPenjualanPelanggan');
Route::name('laporanpenjualan.detail')->get('admin/laporan/penjualandetail', 'LaporanController@showLaporanPenjualanDetail');
Route::name('laporanreturpembelian.detail')->get('admin/laporan/returpembeliandetail', 'LaporanController@showLaporanReturPembelianDetail');
Route::name('laporanreturpenjualan.detail')->get('admin/laporan/returpenjualandetail', 'LaporanController@showLaporanReturPenjualanDetail');
Route::name('laporan.pdf')->get('admin/laporan/pdf/{invoice}', 'LaporanController@invoicePdf');
Route::name('laporan.excel')->get('admin/laporan/excel/{invoice}', 'LaporanController@invoiceExcel');
Route::name('laporan.index')->get('admin/laporan', 'LaporanController@index');

Route::resource('admin/user', 'UserController');
Route::resource('admin/supplier', 'SupplierController');
Route::resource('admin/pelanggan', 'PelangganController');
Route::resource('admin/jenisbarang', 'JenisBarangController');
Route::resource('admin/barang', 'BarangController');
Route::resource('admin/satuanbarang', 'SatuanController');
Route::resource('admin/metodebayar', 'MetodeController');
Route::resource('admin/konversi', 'KonversiBarangController');
Route::resource('admin/pembelian', 'PembelianController');
Route::resource('admin/penjualan', 'PenjualanController');
Route::resource('admin/returpembelian', 'ReturPembelianController');
Route::resource('admin/returpenjualan', 'ReturPenjualanController');

Route::middleware(['pegawai'])->group(function () {}

);
Route::middleware(['admin'])->group(function () {

});
Route::post('/admin/penjualan/savePenjualan', 'PenjualanController@savePenjualanAjax');

Route::name('returpembelian.printfaktur')->get('admin/returpembelian/printfaktur/{id}', 'ReturPembelianController@print');
Route::name('returpenjualan.printfaktur')->get('admin/returpenjualan/printfaktur/{id}', 'ReturPenjualanController@print');

Route::name('pembelian.printfaktur')->get('admin/pembelian/printfaktur/{id}', 'PembelianController@printfaktur');
Route::name('penjualan.printfaktur')->get('admin/penjualan/printfaktur/{id}', 'PenjualanController@printfaktur');
Route::name('penjualan.printsuratjalan')->get('admin/penjualan/printsuratjalan/{id}', 'PenjualanController@printsuratjalan');
Route::name('penjualan.printthermal')->get('admin/penjualan/printthermal/{id}', 'PenjualanController@printthermal');
Route::name('penjualan.printthermalauto')->post('admin/fakturpenjualan/print/{id}', 'PenjualanController@printThermalAuto');

// Authentication Routes...
//$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
//$this->post('login', 'Auth\LoginController@login');
//$this->post('logout', 'Auth\LoginController@logout')->name('logout');

//Route::get('/home', 'HomeController@index')->name('home');
