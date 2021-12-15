@extends('base')
@push('custom-css')
<style>

table, th, td {
  border: 1px solid black !important;
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
            <h1>Detail Pembelian</h1>
            <section class="invoice">
              <!-- title row -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header" align="center">
                    <i class="fa fa-money"></i> DRAGON KOI CENTER
                  </h2>
                  <small class="pull-right">Tanggal: {{ date('d-m-Y') }}</small>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                  Kepada
                  <address>
                    <strong>DRAGON KOI CENTER<br>
                    Green Ville Blok L no. 1<br>
                    Jakarta Barat 11510<br>
                    Telp : 021-5674758/59<br>
                    Fax  : 021-5686564
                    </strong>
                  </address>
                </div>
                <div class="col-sm-6 invoice-col">
                @if(!is_null($data->supplier))
                  Dari
                  <address>
                    <strong>{{ $data->supplier->nama }}<br>
                    {{ $data->supplier->alamat }}<br>
                    {{ $data->supplier->kota }}<br>
                    Telp : {{ $data->supplier->telp_1 }} <br> {{ $data->supplier->telp_2 }}<br>
                    </strong>
                  </address>
                @endif
                </div>
                <!-- /.col -->
              </div>
              <div class="row">
                <br><br>
                <div class="col-xs-6 pull-left">
                  <div class="col-xs-5">No. Faktur</div><div class="col-xs-7">: {{ $data->no_faktur }}</div>
                  <div class="col-xs-5">Tanggal Faktur</div><div class="col-xs-7">: {{ date('d-M-Y', strtotime($data->tgl_beli)) }}</div>
                </div>
                <div class="col-xs-6 pull-right">
                  <div class="col-xs-5">Keterangan</div><div class="col-xs-7">: {{ $data->keterangan }}</div>
                </div>
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-xs-12 table-responsive">
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
                            <td>Rp {{ number_format($detail->harga_barang) }}</td>
                            <td>Rp {{ number_format($detail->subtotal) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4"></td><td>Total</td>
                        <td>Rp {{ number_format($data->hrg_total) }}</td>
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
                  <a href="{{ route('pembelian.printfaktur', ['id' => encrypt($data->no_faktur)]) }}" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Print</a>
                  <a href="{{ route('pembelian.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
              </div>
            </section>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection