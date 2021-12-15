@extends('base')
@section('title', 'Laporan Penjualan')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Laporan Penjualan By Metode Pembayaran</h1>
            <hr>
            <form action="{{ route('laporanpenjualan.metode') }}" method="get">
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
                            <label for="metode">Metode Bayar :</label>
                            <select class="form-control select2" id="metode" name="metode">
                                <option selected disabled value="">Pilih Metode Bayar</option>
                                @foreach($metodes as $metode)
                                {
                                    <option value="{{ $metode->id }}" {{ request()->get('metode') == $metode->id ? 'selected':'' }}>{{ $metode->nama_metode }}</option>
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
                            <a href="{{ route('laporanpenjualan.metode') }}" class="btn btn-md btn-danger">Reset</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="MyTableReport">
                    <thead>
                    <tr>
                        <th>Faktur</th>
                        <th>Tanggal Penjualan</th>
                        <th>Pelanggan</th>
                        <th>No Telp</th>
                        <th>Total Belanja</th>
                        <th>Metode Bayar</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><strong>{{ $order->no_faktur }}</strong></td>
                            <td>{{ date('d-m-Y', strtotime($order->tgl_jual)) }}</td>
                            <td>{{ $order->pelanggan->nama }}</td>
                            <td>{{ $order->pelanggan->telp_1 }}|{{ $order->pelanggan->telp_2 }}</td>
                            <td>Rp {{ number_format($order->hrg_total) }}</td>
                            <td>{{ $order->metode->nama_metode }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="6">Tidak ada data transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr><td colspan="4">Total</td><td colspan="2">Rp {{ number_format($total) }}</td></tr>
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

    var metode = $('#metode option:selected').val();
    var message = '';
    if(metode != "")
        message = message + 'Metode Pembayaran : ' + $('#metode option:selected').text() + '<br>';

  $('#MyTableReport').DataTable({
        dom: 'Bflrtip',
        order: [],
        buttons: [
            {
                extend: 'print',
                title: 'Laporan Penjualan By Metode Bayar | Dragon Koi',
                message: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripHtml: false
                }
            },
            'pdf', 'csv',
            {
                extend: 'excel',
                title: 'LAPORAN PENJUALAN BY METODE PEMBAYARAN',
                messageTop: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripNewlines: false
                },
                filename: function() {
                    var date_edition = moment().format("DDMMYYYY");
                    return  'Laporan Penjualan By Metode Bayar - ' + date_edition;
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