@extends('base')
@push('custom-css')
<style>
#total{
    text-align: right;
}
#detail_pembelian{
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
@section('title', 'Pembelian')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Pembelian Barang</h1>
            <form autocomplete="off" action="{{ route('pembelian.store') }}" method="post">
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
                                    <label for="kode">Kode Pembelian :</label>
                                    <input readonly type="text" class="form-control" id="kode" name="kode" value="{{ $kode }}">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_beli">Tanggal Pembelian :</label>
                                    <input type="date" class="form-control" id="tgl_beli" name="tgl_beli" value="{{ date('Y-m-d') }}">
                                </div> 
                                <div class="form-group">
                                    <label for="supplier">Pilih Supplier :</label>
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('supplier') !!}</span>
                                    @endif
                                    <select class="form-control select2" id="supplier" name="supplier" autofocus>
                                        <option selected disabled value="">Pilih Supplier</option>
                                        @foreach($suppliers as $supplier)
                                        {
                                            <option value="{{ $supplier->id }}">{{ $supplier->nama }} ({{ $supplier->kota }}) - {{ $supplier->alamat }}</option>
                                        }
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telp1">No. Telp 1:</label>
                                        <div class="form-control" id="telp1" name="telp1"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telp2">No. Telp 2:</label>
                                        <div class="form-control" id="telp2" name="telp2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama:</label>
                                    <div class="form-control" id="nama" name="nama"></div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <div class="form-control" id="alamat" name="alamat"></div>
                                </div>
                                <div class="form-group">
                                    <label for="kota">Kota:</label>
                                    <div class="form-control" id="kota" name="kota"></div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan:</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" readonly=""></textarea>
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
                    <div class="box-body" id="detail_pembelian">
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
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Sub Total</th>
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
                                    <input type="text" class="form-control" id="search_barcode" name="search_barcode" autofocus="true" placeholder="Masukkan Barcode/Kode Barang" onkeyup="this.value = this.value.toUpperCase();">
                                    <!-- <div class="autocomplete" style="width:100%;">
                                        <input type="text" class="form-control" id="search_nama" name="search_nama" autofocus="true" placeholder="Masukkan Nama Barang">
                                    </div> -->
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
                                <div class="form-group">
                                    <button type="button" class="btn btn-md btn-primary" onclick="cariBarangAuto(); return false;" id="cari">Cari</button>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="total">TOTAL</label>
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('hrg_total') !!}</span>
                                    @endif
                                    <input type="text" readonly class="form-control" id="hrg_total" name="hrg_total">
                                </div>
                                <div class="form-group">
                                    <label for="ket">KETERANGAN :</label>
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('ket') !!}</span>
                                    @endif
                                    <input type="text" class="form-control" id="ket" name="ket" placeholder="Isi Keterangan">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-primary">Simpan</button>
                                </div>
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
    $('#ket').val('');
    $('#hrg_total').val('');
    $('#search_barcode').keypress(function (e) {
        var code = e.keyCode || e.which;
        if (code === 13)
        {
            e.preventDefault();
            //cariBarang();
            cariBarangAuto();
        }
    });
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
//                     this.parentNode.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang[]' value='"+harga+"'>"+harga+"";
//                     var qty_old = this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value;
//                     this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value = parseInt(qty_old)+parseInt(qty);
//                     var subtotal = parseFloat(harga)*(parseInt(qty_old)+parseInt(qty));
//                     this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"";
//                 }
//             });
//             if(!exist)
//             {
//                 $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td><input type='hidden' name='harga_barang[]' value='"+harga+"'>"+harga+"</td><td><input type='number' id='jmlh' name='jmlh[]' value='"+qty+"' min='1' max='"+maks+"'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
//             }
//         }
//         else
//         {
//             $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td><input type='hidden' name='harga_barang[]' value='"+harga+"'>"+harga+"</td><td><input type='number' id='jmlh' name='jmlh[]' value='"+qty+"' min='1' max='"+maks+"'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
//         }
//     }
//     $('#search_barcode').val('');
//     $('#kodebarang').val('');
//     $('#namabarang').val('');
//     $('#jual').val('');
//     $('#jenis').val('');
//     $('#qty').val('');
// });
$(document).on('click', '#hapus', function() {
  var row = this.parentNode.parentNode;
  var subtotal = this.parentNode.previousSibling.firstChild.value; 
  if(isNaN(subtotal) || subtotal == "")
    subtotal = 0;
  else
    subtotal = subtotal;
  if(isNaN($('#hrg_total').val()) || $('#hrg_total').val() == "")
    var total = 0;
  else
    total = $('#hrg_total').val();
  total = parseFloat(total) - parseFloat(subtotal);
  $('#hrg_total').val(total);
  row.parentNode.removeChild(row);
});

$(document).on('keydown', '#jmlh', function() {
  $(this).numericInput({ allowFloat: false, allowNegative: false });
});
$(document).on('change', '#jmlh', function() {
  var harga = parseFloat(this.parentNode.previousSibling.firstChild.value);
  var qty = parseFloat(this.value);
  var subtotal = harga*qty;
  var old_subtotal = this.parentNode.nextSibling.firstChild.value;
  if(isNaN($('#hrg_total').val()) || $('#hrg_total').val() == "")
    var total = 0;
  else
    total = $('#hrg_total').val();
  total = parseFloat(total) - parseFloat(old_subtotal) + parseFloat(subtotal);
  this.parentNode.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"";
  $('#hrg_total').val(total);
});

$(document).on('change', '#supplier', function() {  
    var supplier = $('#supplier').val();
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxSupplier') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { id : supplier },
        async  : false,
        dataType: 'json',
        encode  : true,
        success: function (response) {
            if(response.success)
            {
                $('#nama').text(response.data.nama);
                $('#telp1').text(response.data.telp_1);
                $('#telp2').text(response.data.telp_2);
                $('#alamat').text(response.data.alamat);
                $('#kota').text(response.data.kota);
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
// $(document).on('keydown', '#search_nama', function() {
//     clearTimeout(timer);
//     var ms = 1000; // milliseconds
//     var nama = this.value;
//     if(nama.length > 2)
//     {
//         timer = setTimeout(function() {
            
//         }, ms);
//         $.ajax({
//                 type   : 'POST',
//                 url    : '{{ url('/getAjaxNamaBarang') }}',
//                 headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
//                 data   : { nama : nama },
//                 async  : false,
//                 dataType: 'json',
//                 encode  : true,
//                 success: function (response) {
//                     var barangs = [];
//                     if(response.success)
//                     {
//                         for(var x=0; x<response.data.length; x++)
//                         {
//                             barangs.push(response.data[x].kode+ " - " + response.data[x].nama);
//                         }
//                     }
//                     autocomplete(document.getElementById("search_nama"), barangs);
//                     // $('#search_nama').autocomplete({
//                     //     minLength : 2,
//                     //     source : barangs,
//                     //     autoFocus: true,
//                     //     select : function(event, ui) {
//                     //         $('#kodebarang').val(ui.item.kode);
//                     //         $('#namabarang').val(ui.item.nama);
//                     //         $('#jual').val(ui.item.harga_jual);
//                     //         $('#jenis').val(ui.item.jenisbarang.jenis);
//                     //     }
//                     // })
//                     // .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
//                     //    return $( "<li>" )
//                     //    .append("(" + item.kode + ") " + item.nama)
//                     //    .appendTo( ul );
//                     // };
//                 }
//             });
//     }
//     //var nama = $(this).val();
// });
$(document).on('change', '#search_nama', function() {
    var kodebarang = $('#search_nama').val();
    $('#search_barcode').val(kodebarang);
});
function cariBarang()
{
    var barcode = $('#search_barcode').val();

    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxBarang') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { barcode : barcode },
        async  : false,
        dataType: 'json',
        encode  : true,
        success: function (response) {
            if(response.success)
            {
                if(response.data.stok > 0)   
                {
                    $('#kodebarang').val(response.data.kode);
                    $('#namabarang').val(response.data.nama);
                    $('#beli').val(response.data.harga_beli);
                    $('#jenis').val(response.data.jenisbarang.jenis);
                    //$('#qty').val(1);
                    //$('#qty').attr("max", response.data.stok);
                }
                else
                    alert('Stok barang kurang. Silahkan cek master barang');
            }
            else
            {
                alert('Barang tidak ditemukan. Refresh atau coba lagi');
            }
            $('#search_barcode').focus();
        },
        error: function (response) {
            var url = location.pathname;
            window.location = url;
        }
    });
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
                    var jenisbarang = response.data.jenisbarang.jenis;
                    var kodebarang = response.data.kode;
                    var namabarang = response.data.nama;
                    var harga = response.data.harga_beli;
                    var qty = 1;
                    rowNum++;
                    var exist = 0;
                    if(kodebarang != "" && namabarang != "" && harga != "" && qty != "")
                    {
                        var subtotal = parseFloat(harga)*parseFloat(qty);
                        if(isNaN($('#hrg_total').val()) || $('#hrg_total').val() == "")
                        {
                            var total = 0;
                        }
                        else
                            total = $('#hrg_total').val();
                        total = parseFloat(total) + parseFloat(subtotal);
                        $('#hrg_total').val(total);
                        if($('#kode_barang').length)
                        {
                            $('input[name^=kode_barang]').each(function(){
                                if($(this).val() == kodebarang)
                                {
                                    exist = 1;
                                    this.parentNode.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='harga_barang[]' value='"+harga+"'>"+harga+"";
                                    var qty_old = this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value;
                                    this.parentNode.nextSibling.nextSibling.nextSibling.firstChild.value = parseInt(qty_old)+parseInt(qty);
                                    var subtotal = parseFloat(harga)*(parseInt(qty_old)+parseInt(qty));
                                    this.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"";
                                }
                            });
                            if(!exist)
                            {
                                $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td><input type='hidden' name='harga_barang[]' value='"+harga+"'>"+harga+"</td><td><input type='number' id='jmlh' name='jmlh[]' value='"+qty+"' min='1'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
                            }
                        }
                        else
                        {
                            $("#tabel_daftar_barang").find("tbody").append("<tr id='"+rowNum+"'><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+kodebarang+"'>"+kodebarang+"</td><td>"+namabarang+"</td><td><input type='hidden' name='harga_barang[]' value='"+harga+"'>"+harga+"</td><td><input type='number' id='jmlh' name='jmlh[]' value='"+qty+"' min='1'></td><td><input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"</td><td><button id='hapus' class='fa fa-minus'></button></td></tr>");
                        }
                    }
                    $('#search_nama').val('').trigger('change.select2');
                    $('#search_barcode').val('');
                }
                else
                {
                    alert('Barang tidak ditemukan. Refresh atau coba lagi');
                }
                $('#search_barcode').focus();
                $('#search_nama').val('').trigger('change.select2');
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