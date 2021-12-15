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
    min-height: 300px;
    border: 1px dotted grey;
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
            <form action="{{ route('pembelian.update') }}" method="post">
                @csrf
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
                                    <input readonly type="text" class="form-control" id="kode" name="kode" value="{{ $data->no_faktur }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_beli">Tanggal Pembelian :</label>
                                    <input type="date" class="form-control" id="tgl_beli" name="tgl_beli" value="{{ $data->tgl_beli }}">
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="supplier">Pilih Supplier :</label>
                                    @if(count($errors) > 0)
                                        <span class="label label-danger">{!! $errors->first('supplier') !!}</span>
                                    @endif
                                    <select class="form-control select2" id="supplier" name="supplier">
                                        <option selected disabled value="">Pilih Supplier</option>
                                        @foreach($suppliers as $supplier)
                                        {
                                            <option value="{{ $supplier->id }}" {{ $supplier->id == $data->supplier_id ? 'selected=selected' : '' }}>{{ $supplier->nama }} ({{ $supplier->kota }}) - {{ $supplier->telp }}</option>
                                        }
                                        @endforeach
                                    </select>
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
                            <div class="col-md-12">
                                <div class="table-responsive" id="tabel_daftar_barang">
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
                                            @foreach($details as $detail)
                                                <tr>
                                                    <td><input type="hidden" name="kode_barang[]" value="{{ $detail->kode_barang }}">{{ $detail->kode_barang }}</td>
                                                    <td><input type="hidden" name="harga_barang[]" value="{{ $detail->harga_barang }}">{{ $detail->kode_barang }}</td>
                                                    <td><input type="number" id="jmlh" name="jmlh[]"" value="{{ $detail->jmlh }}" min="1"></td>
                                                    <td><input type="hidden" name="subtotal[]" value="{{ $detail->subtotal }}">{{ $detail->subtotal }}</td>
                                                    <td><td><button id="hapus" class="fa fa-minus"></button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-9 pull-right">
                                <div class="form-group">
                                    <label for="total">TOTAL</label>
                                    <input type="text" readonly class="form-control" id="hrg_total" name="hrg_total" value="{{ $data->hrg_total }}">
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



</script>
@endpush