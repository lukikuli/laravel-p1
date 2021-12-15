@extends('base')
@section('title', 'Laporan Retur Penjualan')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Laporan Retur Penjualan By Detail</h1>
            <hr>
            <form action="{{ route('laporanreturpenjualan.detail') }}" method="get">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mulai Tanggal</label>
                            <input type="date" name="start_date" class="form-control" id="start_date" value="{{ request()->get('start_date') }}">
                        </div>
                        <div class="form-group">
                            <label for="">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" id="end_date" value="{{ request()->get('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="faktur">Faktur Penjualan :</label>
                            <select class="form-control select2" id="faktur" name="faktur">
                                <option selected disabled value="">Pilih No Faktur</option>
                                @foreach($orders as $order)
                                {
                                    <option value="{{ $order->no_faktur }}" {{ request()->get('faktur') == $order->no_faktur ? 'selected':'' }}> {{ $order->no_faktur }} ({{ $order->pelanggan->nama }})</option>
                                }
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="barang">Barang :</label>
                            <select class="form-control select2" id="barang" name="barang">
                                <option selected disabled value="">Pilih Barang</option>
                                @foreach($barangs as $barang)
                                {
                                    <option value="{{ $barang->kode }}" {{ request()->get('barang') == $barang->kode ? 'selected':'' }}>{{$barang->kode}} - {{ $barang->nama }}</option>
                                }
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Proses</button>
                            <a href="{{ route('laporanreturpenjualan.detail') }}" class="btn btn-md btn-danger">Reset</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="MyTableReport">
                    <thead>
                    <tr>
                        <th>No Retur</th>
                        <th>Tanggal Retur</th>
                        <th>Pelanggan</th>
                        <th>Nama Brg (Kode)</th>
                        <th>Qty</th>
                        <th>Harga Brg</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($returs as $retur)
                        <tr>
                            <td><strong>{{ $retur->returpenjualan->no_retur }}</strong></td>
                            <td>{{ date('d-m-Y', strtotime($retur->returpenjualan->tgl_retur)) }}</td>
                            <td>{{ $retur->returpenjualan->penjualan->pelanggan->nama }} - {{ $retur->returpenjualan->penjualan->pelanggan->telp_1 }}</td>
                            <td>{{ $retur->barang->nama }} ({{ $retur->kode_barang }})</td>
                            <td>{{ $retur->jmlh_retur }}</td>
                            <td>Rp {{ number_format($retur->harga_barang) }}</td>
                            <td>Rp {{ number_format($retur->subtotal) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="7">Tidak ada data transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr><td colspan="6">Total</td><td>Rp {{ number_format($total) }}</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection

@push('custom-scripts')
<script type="text/javascript">
$(document).ready(function() {

    var faktur = $('#faktur option:selected').val();
    var barang = $('#barang option:selected').val();
    var message = '';
    if(faktur != "")
        message = message + 'No Faktur : ' + $('#faktur option:selected').text() + '<br>';
    if(barang != "")
        message = message + 'Barang : ' + $('#barang option:selected').text() + '<br>';

  $('#MyTableReport').DataTable({
        dom: 'Bflrtip',
        buttons: [
            {
                extend: 'print',
                title: 'Laporan RETUR PENJUALAN | Dragon Koi',
                message: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripHtml: false
                }
            },
            'pdf', 'csv',
            {
                extend: 'excel',
                title: 'LAPORAN RETUR PENJUALAN BY DETAIL',
                messageTop: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripNewlines: false
                },
                filename: function() {
                    var date_edition = moment().format("DDMMYYYY");
                    return  'Laporan Retur Penjualan By Detail - ' + date_edition;
                }
            }
        ],
        paging: true,
        pageLength: 10,
        "lengthMenu" : [ 10, 25, 50, 75, 100 ],
        searching: true
    });
});
</script>
@endpush