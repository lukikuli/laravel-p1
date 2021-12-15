@extends('base')
@push('custom-css')
<style>
#detail_penjualan{
    min-height: 450px;
}
#tabel_daftar_barang{
    min-height: 300px;
    border: 1px dotted grey;
}
</style>
@endpush
@section('title', 'Retur Penjualan')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Retur Penjualan</h1>
            <form action="{{ route('returpenjualan.store') }}" method="post">
                @csrf
                <!-- Data Penjualan dan Pelanggan -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Retur Penjualan</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode">No Retur :</label>
                                    <input readonly type="text" class="form-control" id="kode" name="kode" value="{{ $kode }}">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_retur">Tanggal Retur :</label>
                                    <input type="date" class="form-control" id="tgl_retur" name="tgl_retur" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label for="pelanggan">Pilih Pelanggan :</label>
                                    <select class="form-control select2" id="pelanggan" name="pelanggan">
                                        <option selected disabled value="">Pilih Pelanggan</option>
                                        @foreach($pelanggans as $pelanggan)
                                        {
                                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }} - {{ $pelanggan->telp_1 }} / {{ $pelanggan->telp_2 }}</option>
                                        }
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="faktur_pelanggan">
                                    <label for="search_faktur_pelanggan">Cari Faktur Penjualan :</label>
                                    <select class="form-control select2" id="search_faktur_pelanggan" name="search_faktur_pelanggan">
                                        <option selected disabled value="">Pilih Faktur Penjualan</option>
                                    </select>
                                </div>
                                <div class="form-group" id="faktur_only">
                                    <label for="search_faktur">Cari Faktur Penjualan :</label>
                                    <input type="text" class="form-control" id="search_faktur" name="search_faktur" autofocus="true" placeholder="Masukkan No Faktur">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-md btn-primary" onclick="cariFaktur(); return false;" id="cari">Cari</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_faktur">No Faktur :</label>
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('no_faktur') !!}</span>
                                    @endif
                                    <input type="text" readonly class="form-control" id="no_faktur" name="no_faktur">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_jual">Tanggal Penjualan :</label>
                                    <input type="text" readonly class="form-control" id="tgl_jual" name="tgl_jual">
                                </div>
                                <div class="form-group">
                                    <label for="pelanggan">Pelanggan :</label>
                                    <input type="text" readonly class="form-control" id="pelanggan" name="pelanggan">
                                </div>
                                <div class="form-group">
                                    <label for="total">Total Penjualan :</label>
                                    <input type="text" readonly class="form-control" id="total" name="total">
                                </div>
                                <div class="form-group">
                                    <label for="metode">Metode Bayar :</label>
                                    <input type="text" readonly class="form-control" id="metode" name="metode">
                                </div>
                            </div>
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">Daftar Barang</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="detail_penjualan">
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-md-12">
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
                                                <th>Qty Jual</th>
                                                <th>Qty Retur</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_daftar_barang_body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-3">
                            </div>
                            <div class=" col-md-9">
                                <div class="form-group">
                                    <label for="ket">KETERANGAN :</label>
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('ket') !!}</span>
                                    @endif
                                    <input type="text" class="form-control" id="ket" name="ket" placeholder="Isi Keterangan">
                                </div>
                            </div>
                        </div>
                        <div class="row pull-right">
                            <div class="col-md-12">
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
$(document).ready(function() { 
    $('#search_faktur_pelanggan').val('');
    $('#search_faktur').val('');
    $('#no_faktur').val('');
    $('#tgl_jual').val('');
    $('#pelanggan').val('');
    $('#total').val('');
    $('#metode').val('');
});
$(document).on('change', '#pelanggan', function() {
    $('#faktur_only').hide();
    var pelanggan = $(this).val();
    $('#search_faktur_pelanggan').find('option').remove();
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxPenjualanPelanggan') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { pelanggan : pelanggan },
        async  : false,
        dataType: 'JSON',
        success: function (response) {
            if(response.success)
            {
                $("#search_faktur_pelanggan").select2({placeholder: "Pilih Faktur"});
                $('#search_faktur_pelanggan').append($("<option selected disabled></option>").attr("value","").text(""));
                for(var x=0; x<response.data.length; x++)
                    $('#search_faktur_pelanggan').append("<option value='"+response.data[x].no_faktur+"'>"+response.data[x].no_faktur+"</option>");
            }
            else
            {
                alert('Pelanggan tidak memiliki riwayat transaksi');
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
});
$('#search_faktur').keydown(function (e) {
    var code = e.keyCode || e.which;
    if (code === 13)
    {
        e.preventDefault();
        cariFaktur();
    }
});
$(document).on('click', '#hapus', function() {
  var row = this.parentNode.parentNode;
  row.parentNode.removeChild(row);
});
$(document).on('change', '#jmlh_retur', function() {
  $(this).numericInput({ allowFloat: false, allowNegative: false });
  var harga = parseFloat(this.parentNode.previousSibling.previousSibling.firstChild.value);
  var qty = parseFloat(this.value);
  this.parentNode.nextSibling.firstChild.setAttribute('max', qty);
 //$('#jmlh_ganti').attr('max', qty);
});
$(document).on('change', '#jmlh_ganti', function() {
  $(this).numericInput({ allowFloat: false, allowNegative: false });
});
$(document).on('change', '#search_faktur_pelanggan', function() {
    $('#search_faktur').val($(this).val());
});

function cariFaktur()
{
    var nofaktur = $('#search_faktur').val();
    var to = $('#tabel_daftar_barang_body');
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxPenjualan') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { faktur : nofaktur },
        async  : false,
        dataType: 'JSON',
        success: function (response) {
            if(response.success)
            {
                $("#tabel_daftar_barang").find("tbody tr").empty();
                $('#search_faktur').val('');
                $('#no_faktur').val(response.data.no_faktur);
                $('#tgl_jual').val(response.data.tgl_jual);
                $('#total').val(response.data.hrg_total);
                $('#metode').val(response.data.metode.nama_metode);
                $('#pelanggan').val(response.data.pelanggan.nama);
                for(var x=0; x<response.details.length; x++)
                {
                    $("<tr><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+response.details[x].kode_barang+"'>"+response.details[x].kode_barang+"</td><td>"+response.details[x].barang.nama+"</td><td><input type='hidden' name='harga_barang[]' value='"+response.details[x].harga_barang+"'>"+response.details[x].harga_barang+"</td><td>"+response.details[x].jmlh+"</td><td><input type='number' id='jmlh_retur' name='jmlh_retur[]' min='1' max='"+response.details[x].jmlh+"'></td><td><input type='hidden' name='subtotal[]' value=''></td><td><button id='hapus' class='fa fa-minus'></button></td></tr>").appendTo(to);
                }
                $('#hrg_total').val('0');
            }
            else
            {
                alert('Pembelian tidak ditemukan. Refresh atau coba lagi');
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
}
function cariFakturPelanggan()
{
    var to = $('#tabel_daftar_barang_body');
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxPenjualan') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { faktur : nofaktur },
        async  : false,
        dataType: 'JSON',
        success: function (response) {
            if(response.success)
            {
                $("#tabel_daftar_barang").find("tbody tr").empty();
                $('#search_faktur').val('');
                $('#no_faktur').val(response.data.no_faktur);
                $('#tgl_jual').val(response.data.tgl_jual);
                $('#total').val(response.data.hrg_total);
                $('#metode').val(response.data.metode.nama_metode);
                $('#pelanggan').val(response.data.pelanggan.nama);
                for(var x=0; x<response.details.length; x++)
                {
                    $("<tr><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+response.details[x].kode_barang+"'>"+response.details[x].kode_barang+"</td><td>"+response.details[x].barang.nama+"</td><td><input type='hidden' name='harga_barang[]' value='"+response.details[x].harga_barang+"'>"+response.details[x].harga_barang+"</td><td>"+response.details[x].jmlh+"</td><td><input type='number' id='jmlh_retur' name='jmlh_retur[]' min='1' max='"+response.details[x].jmlh+"'></td><td><input type='number' id='jmlh_ganti' name='jmlh_ganti[]' min='1' max=''></td><td><input type='hidden' name='subtotal[]' value=''></td><td><button id='hapus' class='fa fa-minus'></button></td></tr>").appendTo(to);
                }
                $('#hrg_total').val('0');
            }
            else
            {
                alert('Pembelian tidak ditemukan. Refresh atau coba lagi');
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
}
</script>
@endpush