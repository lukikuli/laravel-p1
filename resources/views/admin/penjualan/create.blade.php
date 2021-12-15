@extends('base')
@push('custom-css')
<style>
#total{
    text-align: right;
}
#detail_penjualan{
    min-height: 450px;
}
#search_barang{
    min-height:300px;
}
#tabel_daftar_barang{
    min-height: 550px;
    border: 1px dotted grey;
}
* { box-sizing: border-box; }
body {
  font: 16px Arial;
}
.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}
input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}
input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99999;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9;
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important;
  color: #ffffff;
}
</style>
@endpush
@section('title', 'Penjualan')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Penjualan Barang</h1>
            <form action="javascript:void(0)" method="post" id="form_penjualan">
                @csrf
                <!-- Data Penjualan dan Pelanggan -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Transaksi</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
                        </div>
                    </div>
                    <div class="box-body" id="data_transaksi">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode">Kode Penjualan :</label>
                                    <input readonly type="text" class="form-control" id="kode" name="kode" value="{{ $kode }}">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_jual">Tanggal Penjualan :</label>
                                    <input type="date" class="form-control" id="tgl_jual" name="tgl_jual" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label for="pelanggan">Pilih Customer :</label>
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('pelanggan') !!}</span>
                                    @endif
                                    <select class="form-control select2" id="pelanggan" name="pelanggan" required>
                                        <option selected disabled value="">Pilih Customer</option>
                                        @foreach($pelanggans as $pelanggan)
                                        {
                                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }} - {{ $pelanggan->alamat }}</option>
                                        }
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="telp1">No. Telp 1:</label>
                                        <div class="form-control" id="telp1"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telp2">No. Telp 2:</label>
                                        <div class="form-control" id="telp2"></div>
                                    </div>
                                </div>
                                <div class="form-group" style="overflow-y:scroll; height:200px;">
                                    <div class="form-group">
                                        <label for="riwayat">Riwayat Transaksi:</label>
                                        <div id="riwayat"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Customer:</label>
                                    <div class="form-control" id="nama"></div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <div class="form-control" id="alamat" style="overflow-y: scroll; height: 100px;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan:</label>
                                    <textarea class="form-control" id="keterangan" readonly style="min-height:250px; resize: none"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">Daftar Barang</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="detail_penjualan">
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="table-responsive" id="tabel_daftar_barang">
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('tabel') !!}</span>
                                    @endif
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama Barang</th>
                                                <th>Harga(Rp)</th>
                                                <th>Extra Biaya(Rp)</th>
                                                <th>Diskon(Rp)</th>
                                                <th>Harga Akhir(Rp)</th>
                                                <th>Qty</th>
                                                <th>Sub Total(Rp)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3" id="search_barang">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search_barcode" autofocus="true" placeholder="Masukkan Barcode/Kode Barang" onkeyup="this.value = this.value.toUpperCase();">
                                </div>
                                <div class="form-group">atau</div>
                                <div class="form-group">
                                    <select class="form-control select2" id="search_nama">
                                        <option selected disabled value="">Masukkan Nama Barang</option>
                                        @foreach($barangs as $barang)
                                        {
                                            <option value="{{ $barang->kode }}">{{ $barang->nama }}</option>
                                        }
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="form-group">
                                    <button type="button" class="btn btn-md btn-primary" onclick="cariBarangAuto(); return false;" id="cari">Cari</button>
                                </div> -->
                                <!-- <div class="form-group">
                                    <input readonly type="text" class="form-control" id="kodebarang" placeholder="Kode Barang">
                                    <input readonly type="text" class="form-control" id="namabarang" placeholder="Nama Barang">
                                </div>
                                <div class="form-group">
                                    <input readonly type="text" class="form-control" id="jual" placeholder="Harga">
                                    <input readonly type="text" class="form-control" id="jenis" placeholder="Jenis Barang">
                                    <input type="number" class="form-control pull-left" id="qty" style="width:10em;" placeholder="Jumlah" value="1">
                                    <button type="button" class="btn btn-md btn-primary pull-right" id="tambah">Tambah</button>
                                </div> -->
                                <div class="form-group">
                                    <label for="total">TOTAL</label>
                                    <input type="text" class="form-control" id="hrg_total" name="hrg_total">
                                </div>
                                <div class="form-group">
                                    <label for="bayar">Bayar :</label>
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('bayar') !!}</span>
                                    @endif
                                    <input type="text" class="form-control" id="bayar" name="bayar" placeholder="Jumlah Bayar">
                                </div>
                                <div class="form-group">
                                    <label for="kembali">Kembali :</label>
                                    <input type="text" readonly class="form-control" id="kembali" name="kembali">
                                </div>
                                <div class="form-group">
                                    <label for="metode_bayar">Pembayaran :</label>
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('metode_bayar') !!}</span>
                                    @endif
                                    <select class="form-control select2" id="metode_bayar" name="metode_bayar" required>
                                        <option selected disabled value="">Pilih Metode Pembayaran</option>
                                        @foreach($metodes as $metode)
                                        {
                                            <option value="{{ $metode->id }}">{{ $metode->nama_metode }}</option>
                                        }
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-primary" id="send_form">Simpan</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9 pull-right">
                            </div>
                        </div>
                        <div class="row pull-right">
                            <span class="label label-danger errortext"></span>
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </form>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection

@push('custom-scripts')
<script>
var rowNum = 0;
$(document).ready(function() {
    $('#search_barcode').val('');
    $("#bayar").numericInput({ allowFloat: true, allowNegative: false });

    $('#search_barcode').keypress(function (e) {
        var code = e.keyCode || e.which;
        if (code === 13)
        {
            e.preventDefault();
            //cariBarang();
            cariBarangAuto();
        }
    });
    $('#send_form').attr('disabled', 'disabled');
});
if ($("#form_penjualan").length > 0) {
    $("#form_penjualan").validate({
        rules: {
            pelanggan: {
                required: true,
            },
            bayar: {
                required: true,
            },
            metode_bayar: {
                required: true,
            }, 
            tabel_daftar_barang: {
                required: true,
                minlength: 1
            }, 
        },
        messages: {
            pelanggan: {
                required: "<span class='label label-danger'>Pilih customer</span>",
            },      
            bayar: {
                required: "<span class='label label-danger'>Masukkan jumlah bayar</span>"
            },
            metode_bayar: {
                required: "<span class='label label-danger'>Pilih metode bayar</span>"
            },
            tabel_daftar_barang: {
                required: "<span class='label label-danger'>Pilih barang</span>"
            },         
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "bayar" )
                error.insertBefore("#bayar");
            else if (element.attr("name") == "pelanggan")
                error.insertBefore("#pelanggan");
            else
                error.insertBefore(element);
        },
        submitHandler: function(form) {
            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
            $('#send_form').html('Proses..');
            $.ajax({
                type: "POST",
                url: '{{ url('/admin/penjualan/savePenjualan') }}',
                data: $('#form_penjualan').serialize(),
                success: function( response ) {
                    if(response.success)
                    {
                        var url = '{{ url('/admin/penjualan') }}/'+response.id ;
                        //document.getElementById("form_penjualan").reset();
                        //alert(url);
                        location.reload();
                        window.open(url, "_blank");
                    }
                    else
                        $('#form_penjualan').prepend('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>'+response.msg+'</strong></div>');
                }
            });
        }
    });
}

$(document).on('change', '#search_nama', function() {
    var barcode = $(this).val();
    if(barcode.length > 1)
    {
        $.ajax({
            type   : 'POST',
            url    : '{{ url('/getAjaxBarang') }}',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data   : { barcode : barcode },
            async  : true,
            dataType: 'json',
            encode  : true,
            success: function (response) {
                if(response.success)
                {
                    if(response.data.stok > 0)   
                    {
                        var jenisbarang = response.data.jenisbarang.jenis;
                        var kodebarang = response.data.kode;
                        var namabarang = response.data.nama;
                        var harga = response.data.harga_jual;
                        var qty = 1;
                        var maks = response.data.stok;
                        rowNum++;
                        var exist = 0;
                        var editable = '';
                        if(jenisbarang.toLowerCase().includes('service'))
                            hargabarang = "<input type='text' name='harga_barang[]' id='harga_barang' value='"+harga.toLocaleString('id')+"'>";
                        else
                            hargabarang = "<input type='text' name='harga_barang[]' id='harga_barang' value='"+harga.toLocaleString('id')+"' readonly>";
                        if(kodebarang != "" && namabarang != "" && harga != "" && qty != "")
                        {
                            var subtotal = parseFloat(harga)*parseFloat(qty);
                            if(isNaN(parseFloat($('#hrg_total').val())))
                                var total = 0;
                            else
                                total = parseFloat($('#hrg_total').val().replace(/\./g,''));
                            //alert("total "+total);
                            //alert("subtotal "+subtotal);
                            total = total + subtotal;
                            $('#hrg_total').val(total.toLocaleString('id'));
                            if($('#kode_barang').length)
                            {
                                $('input[name^=kode_barang]').each(function(){
                                    if($(this).val() == kodebarang)
                                    {
                                        exist = 1;
                                        this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value = '';
                                        this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value = '';
                                        this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga.toLocaleString('id')+"'>"+harga.toLocaleString('id')+"";
                                        var qty_old = this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value;
                                        //this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value = (parseInt(qty_old)+parseInt(qty));
                                        this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='number' id='jmlh' name='jmlh[]' min='1' value='"+qty+"' max='"+maks+"' autofocus='true'>";
                                        var subtotal = parseFloat(harga)*(parseInt(qty_old)+parseInt(qty));
                                        this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"";
                                    }
                                });
                                if(!exist)
                                {
                                    $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td>"+hargabarang+"</td><td><input name='harga_extra[]' id='harga_extra' type='text' placeholder='Rp'></td><td><input name='diskon_harga[]' id='diskon_harga' type='text' placeholder='Rp'></td><td><input type='hidden' name='harga_barang_diskon[]' value='"+harga.toLocaleString('id')+"'>"+harga.toLocaleString('id')+"</td><td><input type='number' class='"+kodebarang+"' id='jmlh' name='jmlh[]' min='1' value='"+qty+"' max='"+maks+"' autofocus='true'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
                                }
                            }
                            else
                            {
                                $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td>"+hargabarang+"</td><td><input name='harga_extra[]' id='harga_extra' type='text' placeholder='Rp'></td><td><input name='diskon_harga[]' id='diskon_harga' type='text' placeholder='Rp'></td><td><input type='hidden' name='harga_barang_diskon[]' value='"+harga.toLocaleString('id')+"'>"+harga.toLocaleString('id')+"</td><td><input type='number' class='"+kodebarang+"' id='jmlh' name='jmlh[]' min='1' value='"+qty+"' max='"+maks+"' autofocus='true'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
                            }
                        }
                        $('#search_nama').val('').trigger('change.select2');
                        $('#search_barcode').val('');
                        // $('#kodebarang').val('');
                        // $('#namabarang').val('');
                        // $('#jual').val('');
                        // $('#jenis').val('');
                        // $('#qty').val('');
                        $("."+kodebarang).focus();
                    }
                    else
                    {
                        alert('Stok barang habis. Silahkan cek master barang');
                        $('#search_barcode').val('');
                        $('#search_nama').val('').trigger('change.select2');
                        // $('#kodebarang').val('');
                        // $('#namabarang').val('');
                        // $('#jual').val('');
                        // $('#jenis').val('');
                        // $('#qty').val('');
                    }
                }
                else
                {
                    alert('Barang tidak ditemukan. Refresh atau coba lagi');
                }
                //$('#search_barcode').focus();
            },
            error:function (response, status, error) {
                var url = location.pathname;
                window.location = url;
            }
        });
    }
});
// $(document).on('click', '#tambah', function() {

//     var kodebarang = $('#kodebarang').val();
//     var namabarang = $('#namabarang').val();
//     var harga = $('#jual').val();
//     var qty = $('#qty').val();
//     var maks = $('#qty').attr('max');
//     rowNum++;
//     var exist = 0;
//     if(kodebarang != "" && namabarang != "" && harga != "" && qty != "")
//     {
//         var subtotal = parseFloat(harga)*parseFloat(qty);
//         if(isNaN($('#hrg_total').val()) || $('#hrg_total').val() == "")
//         {
//             var total = 0;
//         }
//         else
//             total = $('#hrg_total').val();
//         total = parseFloat(total) + parseFloat(subtotal);
//         $('#hrg_total').val(total);
//         if($('#kode_barang').length)
//         {
//             $('input[name^=kode_barang]').each(function(){
//                 if($(this).val() == kodebarang)
//                 {
//                     exist = 1;
//                     this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value = '';
//                     this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value = '';
//                     this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga+"'>"+harga+"";
//                     var qty_old = this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value;
//                     this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value = parseInt(qty_old)+parseInt(qty);
//                     var subtotal = parseFloat(harga)*(parseInt(qty_old)+parseInt(qty));
//                     this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"";
//                 }
//             });
//             if(!exist)
//             {
//                 $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td><input type='hidden' name='harga_barang[]' value='"+harga+"'>"+harga+"</td><td><input name='diskon_persen[]' id='diskon_persen' type='text' placeholder='%'></td><td><input name='diskon_harga[]' id='diskon_harga' type='text' placeholder='Rp'></td><td><input type='hidden' name='harga_barang_diskon[]' value='"+harga+"'>"+harga+"</td><td><input type='number' id='jmlh' name='jmlh[]' min='1' value='"+qty+"' max='"+maks+"'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
//             }
//         }
//         else
//         {
//             $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td><input type='hidden' name='harga_barang[]' value='"+harga+"'>"+harga+"</td><td><input name='diskon_persen[]' id='diskon_persen' type='text' placeholder='%'></td><td><input name='diskon_harga[]' id='diskon_harga' type='text' placeholder='Rp'></td><td><input type='hidden' name='harga_barang_diskon[]' value='"+harga+"'>"+harga+"</td><td><input type='number' id='jmlh' name='jmlh[]' min='1' value='"+qty+"' max='"+maks+"'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
//         }
//     }
//     $('#search_nama').val('').trigger('change.select2');
//     $('#search_barcode').val('');
//     $('#kodebarang').val('');
//     $('#namabarang').val('');
//     $('#jual').val('');
//     $('#jenis').val('');
//     $('#qty').val('');
// });
$(document).on('click', '#hapus', function() {
    var row = this.parentNode.parentNode;
    if(isNaN(parseFloat(this.parentNode.previousSibling.firstChild.value)))
        var subtotal = 0;
    else
        subtotal = parseFloat(this.parentNode.previousSibling.firstChild.value.replace(/\./g,''));
    if($('#hrg_total').val() == "")
        var total = 1;
    else
        total = parseFloat($('#hrg_total').val().replace(/\./g,''));
    total = total - subtotal;
    row.parentNode.removeChild(row);
    $('#hrg_total').val(total.toLocaleString('id'));
    if(isNaN(parseFloat($('#bayar').val())))
        var bayar = 0;
    else
        bayar = parseFloat($('#bayar').val().replace(/\./g,''));
    var kembali = bayar-total;
    if(kembali > -1)
        $('#kembali').val(kembali.toLocaleString('id'));
    else
        $('#kembali').val('');
});

// $(document).on('keydown', '#harga_barang', function() {
//   this.parentNode.nextSibling.firstChild.value = '';
//   this.parentNode.nextSibling.nextSibling.firstChild.value = '';
//   $(this).numericInput({ allowFloat: false, allowNegative: false });
//   var harga = this.value;
//   var qty = parseFloat(this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value);
//   this.parentNode.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga+"'>"+harga+"";
//   var subtotal = harga*qty;
//   var old_subtotal = this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value;
//   if(isNaN($('#hrg_total').val()) || $('#hrg_total').val() == "")
//     var total = 0;
//   else
//     total = $('#hrg_total').val();
//   total = parseFloat(total) - parseFloat(old_subtotal) + parseFloat(subtotal);
//   this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"";
//   $('#hrg_total').val(total);
// });
$(document).on('keyup', '#harga_barang', function() {
  $(this).numericInput({ allowFloat: false, allowNegative: false });
  if(this.value.length > 3)
    numberWithSeparator(this);
  this.parentNode.nextSibling.firstChild.value = '';
  this.parentNode.nextSibling.nextSibling.firstChild.value = '';

  if(isNaN(parseFloat(this.value)))
    var harga = 0;
  else
    harga = parseFloat(this.value.replace(/\./g,''));
  var qty = parseFloat(this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value);
  this.parentNode.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga.toLocaleString('id')+"'>"+harga.toLocaleString('id')+"";
  var subtotal = harga*qty;
  var old_subtotal = parseFloat(this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value.replace(/\./g,''));
  if(isNaN(parseFloat($('#hrg_total').val())))
    var total = 0;
  else
    total = parseFloat($('#hrg_total').val().replace(/\./g,''));
  total = total - old_subtotal + subtotal;
  this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"";
  $('#hrg_total').val(total.toLocaleString('id'));
    if(isNaN(parseFloat($('#bayar').val())))
        var bayar = 0;
    else
        bayar = parseFloat($('#bayar').val().replace(/\./g,''));
    var kembali = bayar-total;
    if(kembali > -1)
        $('#kembali').val(kembali.toLocaleString('id'));
    else
        $('#kembali').val('');
});
// $(document).on('keydown', '#diskon_persen', function() {
//   //this.parentNode.nextSibling.firstChild.value = '';
//   $(this).numericInput({ allowFloat: false, allowNegative: false });
//     if(isNaN(this.value) || this.value == "" || parseInt(this.value) > 100)
//         var disc = 0;
//     else
//         disc = parseFloat(this.value);
//   var harga = parseFloat(this.parentNode.previousSibling.firstChild.value);
//   var harga_disc = harga-(disc/100*harga);
//   var qty = parseFloat(this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value);
//   var subtotal = harga_disc*qty;
//   var old_subtotal = this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value;
//   if(isNaN($('#hrg_total').val()) || $('#hrg_total').val() == "")
//     var total = 0;
//   else
//     total = $('#hrg_total').val();
//   total = parseFloat(total) - parseFloat(old_subtotal) + parseFloat(subtotal);
//   this.parentNode.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga_disc+"'>"+harga_disc+"";
//   this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"";
//   $('#hrg_total').val(total);
// });
// $(document).on('keydown', '#harga_extra', function() {
//   //this.parentNode.nextSibling.firstChild.value = '';
//   $(this).numericInput({ allowFloat: false, allowNegative: false });

//   const anElement = AutoNumeric.multiple('#harga_extra', 
//   {
//     decimalCharacter: ',',
//     decimalPlaces: 0,
//     digitGroupSeparator: '.',
//     minimumValue: "0"
//   });
//     if(isNaN(this.value) || this.value == "")
//         var ext = 0;
//     else
//         ext = parseFloat(this.value);
//     if(isNaN(this.parentNode.nextSibling.firstChild.value) || this.parentNode.nextSibling.firstChild.value == "")
//         var disc = 0;
//     else
//         disc = parseFloat(this.parentNode.nextSibling.firstChild.value);
//   var harga = parseFloat(this.parentNode.previousSibling.firstChild.value);
//   var harga_tot = harga+ext-disc;
//   var qty = parseFloat(this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value);
//   var subtotal = harga_tot*qty;
//   var old_subtotal = this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value;
//   if(isNaN($('#hrg_total').val()) || $('#hrg_total').val() == "")
//     var total = 0;
//   else
//     total = $('#hrg_total').val();
//   total = parseFloat(total) - parseFloat(old_subtotal) + parseFloat(subtotal);
//   this.parentNode.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga_tot+"'>"+harga_tot+"";
//   this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"";
//   $('#hrg_total').val(total);
// });
$(document).on('keyup', '#harga_extra', function() {
  //this.parentNode.nextSibling.firstChild.value = '';
    $(this).numericInput({ allowFloat: false, allowNegative: false });
    if(this.value.length > 3)
        numberWithSeparator(this);
    if(isNaN(parseFloat(this.value)))
        var ext = 0;
    else
        ext = parseFloat(this.value.replace(/\./g,''));
    if(isNaN(parseFloat(this.parentNode.nextSibling.firstChild.value)))
        var disc = 0;
    else
        disc = parseFloat(this.parentNode.nextSibling.firstChild.value.replace(/\./g,''));
  var harga = parseFloat(this.parentNode.previousSibling.firstChild.value.replace(/\./g,''));
  var harga_tot = harga+ext-disc;
  var qty = parseFloat(this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value);
  var subtotal = harga_tot*qty;
  var old_subtotal = parseFloat(this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value.replace(/\./g,''));
  if(isNaN(parseFloat($('#hrg_total').val())))
    var total = 0;
  else
    total = parseFloat($('#hrg_total').val().replace(/\./g,''));
  total = total - old_subtotal + subtotal;
  this.parentNode.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga_tot.toLocaleString('id')+"'>"+harga_tot.toLocaleString('id')+"";
  this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"";
  $('#hrg_total').val(total.toLocaleString('id'));
    if(isNaN(parseFloat($('#bayar').val())))
        var bayar = 0;
    else
        bayar = parseFloat($('#bayar').val().replace(/\./g,''));
    var kembali = bayar-total;
    if(kembali > -1)
        $('#kembali').val(kembali.toLocaleString('id'));
    else
        $('#kembali').val('');
});

// $(document).on('keydown', '#diskon_harga', function() {
//  //this.parentNode.previousSibling.firstChild.value = '';
//   $("#diskon_harga").numericInput({ allowFloat: false, allowNegative: false });
//   var harga = parseFloat(this.parentNode.previousSibling.previousSibling.firstChild.value);
//     if(isNaN(this.value) || this.value == "" || parseFloat(this.value) > harga)
//         var disc = 0;
//     else
//         disc = parseFloat(this.value);
//     if(isNaN(this.parentNode.previousSibling.firstChild.value) || this.parentNode.previousSibling.firstChild.value == "")
//         var ext = 0;
//     else
//         ext = parseFloat(this.parentNode.previousSibling.firstChild.value);
//   var harga_disc = harga+ext-disc;
//   var qty = parseFloat(this.parentNode.nextSibling.nextSibling.firstChild.value);
//   var subtotal = harga_disc*qty;
//   var old_subtotal = this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value;
//   if(isNaN($('#hrg_total').val()) || $('#hrg_total').val() == "")
//     var total = 0;
//   else
//     total = $('#hrg_total').val();
//   total = parseFloat(total) - parseFloat(old_subtotal) + parseFloat(subtotal);
//   this.parentNode.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga_disc+"'>"+harga_disc+"";
//   this.parentNode.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"";
//   $('#hrg_total').val(total);
// });
$(document).on('keyup', '#diskon_harga', function() {
  //this.parentNode.previousSibling.firstChild.value = '';
  $("#diskon_harga").numericInput({ allowFloat: false, allowNegative: false });
  if(this.value.length > 3)
    numberWithSeparator(this);
  var harga = parseFloat(this.parentNode.previousSibling.previousSibling.firstChild.value.replace(/\./g,''));
    if(isNaN(parseFloat(this.value)))
        var disc = 0;
    else
    {
        disc = parseFloat(this.value.replace(/\./g,''));
        if(disc > harga)
            disc = 0;
    }
    if(isNaN(parseFloat(this.parentNode.previousSibling.firstChild.value)))
        var ext = 0;
    else
        ext = parseFloat(this.parentNode.previousSibling.firstChild.value.replace(/\./g,''));
  var harga_disc = harga+ext-disc;
  var qty = parseFloat(this.parentNode.nextSibling.nextSibling.firstChild.value);
  var subtotal = harga_disc*qty;
  var old_subtotal = parseFloat(this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value.replace(/\./g,''));
  if(isNaN(parseFloat($('#hrg_total').val())))
    var total = 0;
  else
    total = parseFloat($('#hrg_total').val().replace(/\./g,''));
  total = total - old_subtotal + subtotal;
  this.parentNode.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga_disc.toLocaleString('id')+"'>"+harga_disc.toLocaleString('id')+"";
  this.parentNode.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"";
  $('#hrg_total').val(total.toLocaleString('id'));
    if(isNaN(parseFloat($('#bayar').val())))
        var bayar = 0;
    else
        bayar = parseFloat($('#bayar').val().replace(/\./g,''));
    var kembali = bayar-total;
    if(kembali > -1)
        $('#kembali').val(kembali.toLocaleString('id'));
    else
        $('#kembali').val('');
});

$(document).on('change', '#jmlh', function(e) {
  $(this).numericInput({ allowFloat: false, allowNegative: false });
  if(isNaN(parseFloat(this.parentNode.previousSibling.firstChild.value)))
    var harga_disc = 0;
  else
    harga_disc = parseFloat(this.parentNode.previousSibling.firstChild.value.replace(/\./g,''));
  if(isNaN(parseFloat(this.value)))
    var qty = 0;
  else
    qty = parseFloat(this.value.replace(/\./g,''));
  var subtotal = harga_disc*qty;
  if(isNaN(parseFloat(this.parentNode.nextSibling.firstChild.value)))
    var old_subtotal = 0;
  else
    old_subtotal = parseFloat(this.parentNode.nextSibling.firstChild.value.replace(/\./g,''));
  if(isNaN(parseFloat($('#hrg_total').val())))
    var total = 0;
  else
    total = parseFloat($('#hrg_total').val().replace(/\./g,''));
  total = total + subtotal - old_subtotal ;
  this.parentNode.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"";
  $('#hrg_total').val((total).toLocaleString('id'));
    if(isNaN(parseFloat($('#bayar').val())))
        var bayar = 0;
    else
        bayar = parseFloat($('#bayar').val().replace(/\./g,''));
    var kembali = bayar-total;
    if(kembali > -1)
        $('#kembali').val(kembali.toLocaleString('id'));
    else
        $('#kembali').val('');
    var code = e.keyCode || e.which;
    if (code === 13)
    {
        $('#search_barcode').focus();
    }
});
$(document).on('keydown', '#jmlh', function(e) {
    $(this).numericInput({ allowFloat: false, allowNegative: false });
    var code = e.keyCode || e.which;
    if (code === 13)
    {
        $('#search_barcode').focus();
    }
});

$(document).on('keyup', '#bayar', function() {
  $(this).numericInput({ allowFloat: false, allowNegative: false });
  if(this.value.length > 3)
    numberWithSeparator(this);
    if(isNaN(parseFloat($('#hrg_total').val())))
        var hrg_total = 0;
    else
        hrg_total = parseFloat($('#hrg_total').val().replace(/\./g,''));
    if(isNaN(parseFloat($(this).val())))
        var bayar = 0;
    else
        bayar = parseFloat(this.value.replace(/\./g,''));
    if(bayar < hrg_total)
        $('#send_form').attr('disabled', 'disabled');
    else
        $('#send_form').removeAttr('disabled');
    var kembali = bayar-hrg_total;
    if(kembali > -1)
        $('#kembali').val((kembali).toLocaleString('id'));
    else
        $('#kembali').val('');
});

$(document).on('change', '#pelanggan', function() {
    var pelanggan = $('#pelanggan').val();
    var base_url = "{{ url('admin/penjualan') }}";
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxPelanggan') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { id : pelanggan },
        async  : false,
        dataType: 'json',
        encode  : true,
        success: function (response) {
            if(response.success)
            {
                $('#riwayat').empty();
                for(var x=0; x<response.history.length; x++)
                {
                    $('#riwayat').append('<div><a href="'+base_url+'/'+response.history[x].id+'" target="_blank">'+response.history[x].no_faktur+'</a></div>');
                }
                $('#nama').text(response.data.nama);
                $('#telp1').text(response.data.telp_1);
                $('#telp2').text(response.data.telp_2);
                $('#alamat').text(response.data.kota + " - " + response.data.alamat);
                $('#keterangan').val(response.data.keterangan);
            }
            else
            {
                alert('Supplier tidak ditemukan. Refresh atau coba lagi');
            }
            $('#search_barcode').focus();
        }
    });
});

function numberWithSeparator(x) {
  setTimeout(function(){
      var a = x.value.replace(".","");
      var nf = new Intl.NumberFormat('id'); 
      //console.log(nf.format(a));
      x.value = nf.format(a);
  },1);
}
function cariBarang()
{
    var barcode = $('#search_barcode').val();
    if(barcode.length > 1)
    {
        $.ajax({
            type   : 'POST',
            url    : '{{ url('/getAjaxBarang') }}',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data   : { barcode : barcode },
            async  : true,
            dataType: 'json',
            encode  : true,
            success: function (response) {
                if(response.success)
                {
                    if(response.data.stok > 0)   
                    {
                        $('#search_nama').val(response.data.kode).trigger('change.select2');
                        $('#kodebarang').val(response.data.kode);
                        $('#namabarang').val(response.data.nama);
                        $('#jual').val(response.data.harga_jual);
                        $('#jenis').val(response.data.jenisbarang.jenis);
                        $('#qty').val(1);
                        $('#qty').attr("max", response.data.stok);
                    }
                    else
                    {
                        alert('Stok barang habis. Silahkan cek master barang');
                        $('#search_barcode').val('');
                        $('#search_nama').val('').trigger('change.select2');
                        $('#kodebarang').val('');
                        $('#namabarang').val('');
                        $('#jual').val('');
                        $('#jenis').val('');
                        $('#qty').val('');
                    }
                }
                else
                {
                    alert('Barang tidak ditemukan. Refresh atau coba lagi');
                }
                $('#search_barcode').focus();
            },
            error:function (response, status, error) {
                var url = location.pathname;
                window.location = url;
            }
        });
    }
    return false;
}
function cariBarangAuto()
{
    var barcode = $('#search_barcode').val();
    if(barcode.length > 1)
    {
        $.ajax({
            type   : 'POST',
            url    : '{{ url('/getAjaxBarang') }}',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data   : { barcode : barcode },
            async  : true,
            dataType: 'json',
            encode  : true,
            success: function (response) {
                if(response.success)
                {
                    if(response.data.stok > 0)   
                    {
                        var jenisbarang = response.data.jenisbarang.jenis;
                        var kodebarang = response.data.kode;
                        var namabarang = response.data.nama;
                        var harga = response.data.harga_jual;
                        var qty = 1;
                        var maks = response.data.stok;
                        rowNum++;
                        var exist = 0;
                        var editable = '';
                        if(jenisbarang.toLowerCase().includes('service'))
                            hargabarang = "<input type='text' name='harga_barang[]' id='harga_barang' value='"+harga.toLocaleString('id')+"'>";
                        else
                            hargabarang = "<input type='text' name='harga_barang[]' id='harga_barang' value='"+harga.toLocaleString('id')+"' readonly>";
                        if(kodebarang != "" && namabarang != "" && harga != "" && qty != "")
                        {
                            var subtotal = parseFloat(harga)*parseFloat(qty);
                            if(isNaN(parseFloat($('#hrg_total').val())))
                                var total = 0;
                            else
                                total = parseFloat($('#hrg_total').val().replace(/\./g,''));
                            total = total + subtotal;
                            $('#hrg_total').val(total.toLocaleString('id'));
                            if($('#kode_barang').length)
                            {
                                $('input[name^=kode_barang]').each(function(){
                                    if($(this).val() == kodebarang)
                                    {
                                        exist = 1;
                                        this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value = '';
                                        this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value = '';
                                        this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang_diskon[]' value='"+harga.toLocaleString('id')+"'>"+harga.toLocaleString('id')+"";
                                        var qty_old = this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value;
                                        this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.value = (parseInt(qty_old)+parseInt(qty));
                                        var subtotal = parseFloat(harga)*(parseInt(qty_old)+parseInt(qty));
                                        this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"";
                                    }
                                });
                                if(!exist)
                                {
                                    $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td>"+hargabarang+"</td><td><input name='harga_extra[]' id='harga_extra' type='text' placeholder='Rp'></td><td><input name='diskon_harga[]' id='diskon_harga' type='text' placeholder='Rp'></td><td><input type='hidden' name='harga_barang_diskon[]' value='"+harga.toLocaleString('id')+"'>"+harga.toLocaleString('id')+"</td><td><input type='number' class='"+kodebarang+"' id='jmlh' name='jmlh[]' min='1' value='"+qty+"' max='"+maks+"'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
                                }
                            }
                            else
                            {
                                $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td>"+hargabarang+"</td><td><input name='harga_extra[]' id='harga_extra' type='text' placeholder='Rp'></td><td><input name='diskon_harga[]' id='diskon_harga' type='text' placeholder='Rp'></td><td><input type='hidden' name='harga_barang_diskon[]' value='"+harga.toLocaleString('id')+"'>"+harga.toLocaleString('id')+"</td><td><input type='number' class='"+kodebarang+"' id='jmlh' name='jmlh[]' min='1' value='"+qty+"' max='"+maks+"'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal.toLocaleString('id')+"'>"+subtotal.toLocaleString('id')+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
                            }
                        }
                        $('#search_nama').val('').trigger('change.select2');
                        $('#search_barcode').val('');
                        $("."+kodebarang).focus();
                        // $('#kodebarang').val('');
                        // $('#namabarang').val('');
                        // $('#jual').val('');
                        // $('#jenis').val('');
                        // $('#qty').val('');
                    }
                    else
                    {
                        alert('Stok barang habis. Silahkan cek master barang');
                        $('#search_barcode').val('');
                        $('#search_nama').val('').trigger('change.select2');
                        // $('#kodebarang').val('');
                        // $('#namabarang').val('');
                        // $('#jual').val('');
                        // $('#jenis').val('');
                        // $('#qty').val('');
                    }
                }
                else
                {
                    alert('Barang tidak ditemukan. Refresh atau coba lagi');
                }
            },
            error:function (response, status, error) {
                var url = location.pathname;
                window.location = url;
            }
        });
    }
    return false;
}
</script>
@endpush