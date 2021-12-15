@extends('base')
@push('custom-css')
<style>

table, th, td {
  border: 1px solid black !important;
}
</style>
@endpush
@section('title', 'Penjualan')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            @if(Session::has('alert-danger'))
                <div class="alert alert-danger">
                    <strong>{{ \Illuminate\Support\Facades\Session::get('alert-danger') }}</strong>
                </div>
            @endif
            <!-- Remove This Before You Start -->
            <h1>Detail Penjualan</h1>
            <section class="invoice">
              <!-- title row -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header" align="center">
                    <i class="fa fa-money"></i> DRAGON KOI CENTER
                  </h2>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row">
                <!-- /.col -->
                <div class="col-sm-6 col-xs-6 pull-left">
                  <p style="margin:0px; line-height:20px;">
                    DRAGON KOI CENTER<br>
                    Green Ville Blok L no. 1<br>
                    Jakarta Barat 11510<br>
                    Telp : 021-5674758/59<br>
                    Fax  : 021-5686564
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 col-xs-6 pull-right">
                  <p style="margin:0px; line-height:20px;">
                    Tanggal: {{ date('d-M-Y') }}<br>
                    @if(!is_null($data->pelanggan))
                      Kepada Yth.<br>
                        {{ $data->pelanggan->nama }}<br>
                        {{ $data->pelanggan->alamat .", ". $data->pelanggan->kota }}<br>
                        Telp : {{ $data->pelanggan->telp_1 }} {{ $data->pelanggan->telp_2 != null ? ", ". $data->pelanggan->telp_2 : ""}}<br>
                    @endif
                  </p>
                </div>
              </div>
              <!-- /.row -->
              <div class="row">
                <br><br>
                <div class="col-xs-6 pull-left">
                  <div class="col-xs-5">No. Faktur</div><div class="col-xs-7">: {{ $data->no_faktur }}</div>
                  <div class="col-xs-5">Tanggal Faktur</div><div class="col-xs-7">: {{ date('d-M-Y', strtotime($data->tgl_jual)) }}</div>
                </div>
                <div class="col-xs-6 pull-right">
                    <br><div><strong>{{ $data->metode->nama_metode }}</strong></div> 
                </div>
              </div>

              <!-- Table row -->
              <div class="row">
                <div class="col-sm-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>No.</th>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Qty</th>
                      <th>Harga Barang</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($details as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detail->kode_barang }}</td>
                            <td>{{ $detail->barang->nama }}</td>
                            <td>{{ $detail->jmlh }}</td>
                            <td>Rp {{ number_format($detail->harga_barang_diskon) }}</td>
                            <td>Rp {{ number_format($detail->subtotal) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4"></td><td><b>Total</b></td>
                        <td>Rp {{ number_format($data->hrg_total) }}</td>
                      </tr>
                      <tr>
                        <td colspan="4"></td><td><b>Bayar</b></td>
                        <td>Rp {{ number_format($data->bayar) }}</td>
                      </tr>
                      <tr>
                        <td colspan="4"></td><td><b>Kembali</b></td>
                        <td>Rp {{ number_format($data->kembali) }}</td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row">  
                <div class="col-md-12">
                  <div class="pull-right" style="padding-top: 50px;">
                    <strong>{{ Auth::user()->nama }}</strong>
                  </div>
                </div>
              </div>
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-xs-12">
                    <!-- <a href="#" class=" btn btn-md btn-info" onclick="onClick()">Print Thermal</a> -->
                    <a href="{{ route('penjualan.printfaktur', ['id' => encrypt($data->no_faktur)]) }}" class=" btn btn-md btn-primary" target="_blank">Print Faktur</a>
                    <a href="{{ route('penjualan.printsuratjalan', ['id' => encrypt($data->no_faktur)]) }}" class=" btn btn-md btn-info" target="_blank">Print Surat Jalan</a>
                    <a href="{{ route('penjualan.printthermal', ['id' => encrypt($data->no_faktur)]) }}" class=" btn btn-md btn-info" target="_blank">Print Thermal</a>
                  <a href="{{ route('penjualan.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
              </div>
            </section>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection
@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/recta/dist/recta.js"></script>
<script type="text/javascript">
  var array = JSON.parse('{{ json_encode($data) }}');
  var printer = new Recta('APPKEY', '1811');

  function onClick () {
    printer.open().then(function () {
      printer.align('center')
        .bold(true)
        .text('DRAGON KOI CENTER')
        .bold(true)
        .text(array[0].no_faktur)
        .text('This is bold text')
        .bold(false)
        .underline(true)
        .text('This is underline text')
        .underline(false)
        .barcode('UPC-A', '123456789012')
        .cut()
        .print()
    })
  }
</script>
@endpush