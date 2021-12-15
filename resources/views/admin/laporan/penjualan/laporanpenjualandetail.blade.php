@extends('base')
@section('title', 'Laporan Penjualan')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Laporan Penjualan By Detail</h1>
            <hr>
            <form action="{{ route('laporanpenjualan.detail') }}" method="get">
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
                            <label for="pelanggan">Pelanggan :</label>
                            <select class="form-control select2" id="pelanggan" name="pelanggan">
                                <option selected disabled value="">Pilih Pelanggan</option>
                                @foreach($pelanggans as $pelanggan)
                                {
                                    <option value="{{ $pelanggan->id }}" {{ request()->get('pelanggan') == $pelanggan->id ? 'selected':'' }}> {{ $pelanggan->nama }} ({{ $pelanggan->kota }}) - {{ $pelanggan->telp_1 }} | {{ $pelanggan->telp_2 }}</option>
                                }
                                @endforeach
                            </select>
                        </div>
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
                            <a href="{{ route('laporanpenjualan.detail') }}" class="btn btn-md btn-danger">Reset</a>
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
                        <th>Nama Brg (Kode)</th>
                        <th>Qty</th>
                        <th>Harga Barang</th>
                        <th>Metode Bayar</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @foreach($order->detailpenjualans as $detailpenjualan)
                                <tr>
                                    <td><strong>{{ $detailpenjualan->faktur_penjualan }}</strong></td>
                                    <td>{{ date('d-m-Y', strtotime($order->tgl_jual)) }}</td>
                                    <td>{{ $order->pelanggan->nama }} ({{ $order->pelanggan->kota }})</td>
                                    <td>{{ $detailpenjualan->barang->nama }} ({{ $detailpenjualan->kode_barang }})</td>
                                    <td>{{ $detailpenjualan->jmlh }}</td>
                                    <td>Rp {{ number_format($detailpenjualan->harga_barang_diskon) }}</td>
                                    <td>{{ $order->metode->nama_metode }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" align="right">Total</td>
                                <td style="display: none;"></td>
                                <td style="display: none;"></td>
                                <td style="display: none;"></td>
                                <td>{{ $order->detailpenjualans->sum('jmlh') }}</td>
                                <td colspan="2">Rp {{ number_format($order->hrg_total) }}</td>
                                <td style="display: none;"></td>
                            </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="7">Tidak ada data transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
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

    var pelanggan = $('#pelanggan option:selected').val();
    var metode = $('#metode option:selected').val();
    var barang = $('#barang option:selected').val();
    var message = '';
    if(pelanggan != "")
        message = message + 'Pelanggan : ' + $('#pelanggan option:selected').text() + '<br>';
    if(metode != "")
        message = message + 'Metode Pembayaran : ' + $('#metode option:selected').text() + '<br>';
    if(barang != "")
        message = message + 'Barang : ' + $('#barang option:selected').text() + '<br>';

  $('#MyTableReport').DataTable({
        dom: 'Bflrtip',
        order: [],
        buttons: [
            {
                extend: 'print',
                title: 'Laporan Penjualan Detail | Dragon Koi',
                message: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripHtml: false
                }
            },
            'pdf', 'csv',
            {
                extend: 'excel',
                title: 'LAPORAN PENJUALAN BY DETAIL',
                messageTop: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripNewlines: false
                },
                filename: function() {
                    var date_edition = moment().format("DDMMYYYY");
                    return  'Laporan Penjualan By Detail - ' + date_edition;
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