@extends('base')
@push('custom-css')
<style>

table, th, td {
  border: 1px solid black !important;
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
                  Dari
                  <address>
                    <strong>DRAGON KOI CENTER<br>
                    Green Ville Blok L no. 1<br>
                    Jakarta Barat 11510<br>
                    Telp : 021-5674758/59<br>
                    Fax  : 021-5686564
                    </strong>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                @if(!is_null($data->penjualan->pelanggan))
                  Kepada Yth.
                  <address>
                    <strong>{{ $data->penjualan->pelanggan->nama }}</strong><br>
                    {{ $data->penjualan->pelanggan->alamat }}<br>
                    {{ $data->penjualan->pelanggan->kota }}<br>
                    {{ $data->penjualan->pelanggan->telp }}<br>
                  </address>
                @endif
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row">
                <div class="col-sm-2">Retur</div><div class="col-sm-10">: {{ $data->no_retur }}</div>
                <div class="col-sm-2">Faktur</div><div class="col-sm-10">: {{ $data->penjualan->no_faktur }}</div>
                <div class="col-sm-2">Tanggal Retur</div><div class="col-sm-10">: {{ date('d-m-Y', strtotime($data->tgl_retur)) }}</div>
              </div>

              <!-- Table row -->
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Retur</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($details as $detail)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->kode_barang }}</td>
                        <td>{{ $detail->barang->nama }}</td>
                        <td>{{ $detail->jmlh_retur }}</td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row">
                <div class="col-md-12">
                  <strong>Keterangan:</strong> {{ $data->keterangan }}
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
                    <a href="{{ route('returpenjualan.printfaktur', ['id' => encrypt($data->no_retur)]) }}" class=" btn btn-md btn-primary" target="_blank">Print</a>
                  <a href="{{ route('returpenjualan.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
              </div>
            </section>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection