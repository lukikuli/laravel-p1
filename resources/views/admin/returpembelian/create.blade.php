@extends('base')
@push('custom-css')
<style>
#detail_pembelian{
    min-height: 450px;
}
#tabel_daftar_barang{
    min-height: 300px;
    border: 1px dotted grey;
}
</style>
@endpush
@section('title', 'Retur Pembelian')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Retur Pembelian</h1>
            <form autocomplete="off" action="{{ route('returpembelian.store') }}" method="post">
                @csrf
                <!-- Data Penjualan dan Pelanggan -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Retur Pembelian</h3>
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
                                    <label for="supplier">Pilih Supplier :</label>
                                    <select class="form-control select2" id="supplier" name="supplier">
                                        <option selected disabled value="">Pilih Supplier</option>
                                        @foreach($suppliers as $supplier)
                                        {
                                            <option value="{{ $supplier->id }}">{{ $supplier->nama }} - {{ $supplier->telp_1 }} / {{ $supplier->telp_2 }}</option>
                                        }
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="faktur_supplier">
                                    <label for="search_faktur_supplier">Cari Faktur Pembelian :</label>
                                    <select class="form-control select2" id="search_faktur_supplier" name="search_faktur_supplier">
                                        <option selected disabled value="">Pilih Faktur Penjualan</option>
                                    </select>
                                </div>
                                <div class="form-group" id="faktur_only">
                                    <label for="search_faktur">Cari Faktur Pembelian :</label>
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
                                    <label for="tgl_beli">Tanggal Pembelian :</label>
                                    <input type="text" readonly class="form-control" id="tgl_beli" name="tgl_beli">
                                </div>
                                <div class="form-group">
                                    <label for="supplier">Supplier :</label>
                                    <input type="text" readonly class="form-control" id="supplier" name="supplier">
                                </div>
                                <div class="form-group">
                                    <label for="total">Total Pembelian :</label>
                                    <input type="text" readonly class="form-control" id="total" name="total">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan :</label>
                                    <input type="text" readonly class="form-control" id="keterangan" name="keterangan">
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
                    <div class="box-body" id="detail_pembelian">
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
                                                <th>Qty Beli</th>
                                                <th>Qty Retur</th>
                                                <th>Subtotal</th>
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
    $('#search_faktur_supplier').val('');
    $('#search_faktur').val('');
    $('#no_faktur').val('');
    $('#tgl_beli').val('');
    $('#supplier').val('');
    $('#total').val('');
    $('#keterangan').val('');

});
    
$(document).on('change', '#supplier', function() {
    $('#faktur_only').hide();
    var supplier = $(this).val();
    $('#search_faktur_supplier').find('option').remove();
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxPembelianSupplier') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { supplier : supplier },
        async  : false,
        dataType: 'JSON',
        success: function (response) {
            if(response.success)
            {
                $("#search_faktur_supplier").select2({placeholder: "Pilih Faktur"});
                $('#search_faktur_supplier').append($("<option selected disabled></option>").attr("value","").text(""));
                for(var x=0; x<response.data.length; x++)
                    $('#search_faktur_supplier').append("<option value='"+response.data[x].no_faktur+"'>"+response.data[x].no_faktur+"</option>");
            }
            else
            {
                alert('Supplier tidak memiliki riwayat transaksi');
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
  var subtotal = harga*qty;
  this.parentNode.nextSibling.innerHTML = "<input type='hidden' name='subtotal[]' value='"+subtotal+"'>"+subtotal+"";
  $('#hrg_total').val(total);
});
$(document).on('change', '#search_faktur_supplier', function() {
    $('#search_faktur').val($(this).val());
});

function cariFaktur()
{
    var nofaktur = $('#search_faktur').val();
    var to = $('#tabel_daftar_barang_body');
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxPembelian') }}',
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
                $('#tgl_beli').val(response.data.tgl_beli);
                $('#total').val(response.data.hrg_total);
                $('#keterangan').val(response.data.keterangan);
                $('#supplier').val(response.data.supplier.nama);
                for(var x=0; x<response.details.length; x++)
                {
                    $("<tr><td><input type='hidden' id='kode_barang' name='kode_barang[]' value='"+response.details[x].kode_barang+"'>"+response.details[x].kode_barang+"</td><td>"+response.details[x].barang.nama+"</td><td><input type='hidden' name='harga_barang[]' value='"+response.details[x].harga_barang+"'>"+response.details[x].harga_barang+"</td><td>"+response.details[x].jmlh+"</td><td><input type='number' id='jmlh_retur' name='jmlh_retur[]' required min='1' max='"+response.details[x].jmlh+"'></td><td><input type='hidden' name='subtotal[]' value=''></td><td><button id='hapus' class='fa fa-minus'></button></td></tr>").appendTo(to);
                }
                $('#hrg_total').val('0');
            }
            else
            {
                alert('Pembelian tidak ditemukan. Refresh atau coba lagi');
            }
        }
    });
    return false;
}
</script>
@endpush