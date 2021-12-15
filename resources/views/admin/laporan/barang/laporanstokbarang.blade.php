@extends('base')
@section('title', 'Laporan Stok Barang')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Laporan Stok Barang</h1>
            <hr>
            <form action="{{ route('laporanstokbarang') }}" method="get">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenisbarang">Jenis Barang :</label>
                            <select class="form-control select2" id="jenisbarang" name="jenisbarang">
                                <option selected disabled value="">Pilih Jenis Barang</option>
                                @foreach($jenisbarangs as $jenisbarang)
                                {
                                    <option value="{{ $jenisbarang->id }}" {{ request()->get('jenisbarang') == $jenisbarang->id ? 'selected':'' }}>{{ $jenisbarang->jenis }}</option>
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
                            <a href="{{ route('laporanstokbarang') }}" class="btn btn-md btn-danger">Reset</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="MyTableReport">
                    <thead>
                    <tr>Tanggal : {{ date('d-m-Y') }}</tr>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Satuan</th>
                        <th>Stok Min</th>
                        <th>Stok</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                        <tr>
                            <td><strong>{{ $barang->kode }}</strong></td>
                            <td>{{ $barang->nama }}</td>
                            <td>{{ $barang->jenis_id != "" ? $barang->jenisbarang->jenis : "" }}</td>
                            <td>{{ $barang->satuan_id != "" ? $barang->satuan->nama_satuan : "" }}</td>
                            <td>{{ $barang->stok_min }}</td>
                            <td>{{ $barang->stok }}</td>
                            <td>{{ $barang->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="9">Tidak ada data transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr><td colspan="5">Total</td><td colspan="2">{{ $total }}</td></tr>
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
$(document).ready(function()
{
    var jenisbarang = $('#jenisbarang option:selected').val();
    var barang = $('#barang option:selected').val();
    var message = '';
    var date_edition = moment().format("DDMMYYYY");
    if(jenisbarang != "")
        message = message + 'Jenis Barang : ' + $('#jenisbarang option:selected').text() + '<br>';
    if(barang != "")
        message = message + 'Barang : ' + $('#barang option:selected').text() + '<br>';

  $('#MyTableReport').DataTable({
        dom: 'Bflrtip',
        buttons: [
            {
                extend: 'print',
                title: 'Laporan Stok Barang | Dragon Koi',
                //messageTop: message,
                message: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripHtml: false
                }
            },
            'pdf', 'csv',
            {
                extend: 'excel',
                title: 'LAPORAN STOK BARANG',
                //messageTop: 'oi',
                message: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripNewlines: false
                },
                filename: function() {
                    var date_edition = moment().format("DDMMYYYY");
                    return  'Laporan Stok Barang - ' + date_edition;
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