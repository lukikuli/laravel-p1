@extends('base')
@section('title', 'Laporan Pembelian')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Laporan Pembelian By Detail</h1>
            <hr>
            <form action="{{ route('laporanpembelian.detail') }}" method="get">
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
                            <label for="supplier">Supplier :</label>
                            <select class="form-control select2" id="supplier" name="supplier">
                                <option selected disabled value="">Pilih Supplier</option>
                                @foreach($suppliers as $supplier)
                                {
                                    <option value="{{ $supplier->id }}" {{ request()->get('supplier') == $supplier->id ? 'selected':'' }}> {{ $supplier->nama }} ({{ $supplier->kota }}) - {{ $supplier->telp_1 }} | {{ $supplier->telp_2 }}</option>
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
                            <a href="{{ route('laporanpembelian.detail') }}" class="btn btn-md btn-danger">Reset</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="MyTableReport">
                    <thead>
                    <tr>
                        <th>Faktur</th>
                        <th>Tanggal Pembelian</th>
                        <th>Supplier</th>
                        <th>Nama Brg (Kode)</th>
                        <th>Qty</th>
                        <th>Hrg Beli</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @foreach($order->detailpembelians as $detailpembelian)
                                <tr>
                                    <td><strong>{{ $detailpembelian->faktur_pembelian }}</strong></td>
                                    <td>{{ date('d-m-Y', strtotime($order->tgl_beli)) }}</td>
                                    <td>{{ $order->supplier->nama }} ({{ $order->supplier->kota }})</td>
                                    <td>{{ $detailpembelian->barang->nama }} ({{ $detailpembelian->kode_barang }})</td>
                                    <td>{{ $detailpembelian->jmlh }}</td>
                                    <td>Rp {{ number_format($detailpembelian->harga_barang) }}</td>
                                    <td>{{ $order->keterangan }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" align="right">Total</td>
                                <td style="display: none;"></td>
                                <td style="display: none;"></td>
                                <td style="display: none;"></td>
                                <td>{{ $order->detailpembelians->sum('jmlh') }}</td>
                                <td colspan="2">Rp {{ number_format($order->hrg_total) }}</td>
                                <td style="display: none;"></td>
                            </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="7">Tidak ada data transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
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

    var supplier = $('#supplier option:selected').val();
    var barang = $('#barang option:selected').val();
    var message = '';
    if(supplier != "")
        message = message + 'Supplier : ' + $('#supplier option:selected').text() + '<br>';
    if(barang != "")
        message = message + 'Barang : ' + $('#barang option:selected').text() + '<br>';

  $('#MyTableReport').DataTable({
        dom: 'Bflrtip',
        order: [],
        buttons: [
            {
                extend: 'print',
                title: 'Laporan Pembelian Detail | Dragon Koi',
                message: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripHtml: false
                }
            },
            'pdf', 'csv',
            {
                extend: 'excel',
                title: 'LAPORAN PEMBELIAN BY DETAIL',
                messageTop: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripNewlines: false
                },
                filename: function() {
                    var date_edition = moment().format("DDMMYYYY");
                    return  'Laporan Pembelian By Detail - ' + date_edition;
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