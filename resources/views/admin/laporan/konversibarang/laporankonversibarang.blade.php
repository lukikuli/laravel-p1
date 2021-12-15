@extends('base')
@section('title', 'Laporan Konversi Barang')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Laporan Konversi Barang</h1>
            <hr>
            <form action="{{ route('laporankonversibarang') }}" method="get">
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
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Proses</button>
                            <a href="{{ route('laporankonversibarang') }}" class="btn btn-md btn-danger">Reset</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="MyTableReport">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Konversi</th>
                        <th>Kode Barang Keluar</th>
                        <th>Stok Keluar</th>
                        <th>Kode Barang Masuk</th>
                        <th>Stok Masuk</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($konversis as $konversi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date("d-M-Y", strtotime($konversi->tgl_konversi)) }}</td>
                            <td>{{ $konversi->barangkeluar->kode }} - {{ $konversi->barangkeluar->nama }}</td>
                            <td>{{ $konversi->stok_keluar }}</td>
                            <td>{{ $konversi->barangmasuk->kode }} - {{ $konversi->barangmasuk->nama }}</td>
                            <td>{{ $konversi->stok_masuk }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="9">Tidak ada data transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr><td colspan="3">Total</td><td colspan="2">{{ $total1 }}</td><td>{{ $total2 }}</td></tr>
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

    var jenisbarang = $('#jenisbarang option:selected').val();
    var barang = $('#barang option:selected').val();
    var message = '';
    if(jenisbarang != "")
        message = message + 'Jenis Barang : ' + $('#jenisbarang option:selected').text() + '<br>';
    if(barang != "")
        message = message + 'Barang : ' + $('#barang option:selected').text() + '<br>';

  $('#MyTableReport').DataTable({
        dom: 'Bflrtip',
        buttons: [
            {
                extend: 'print',
                title: 'Laporan Konversi Barang | Dragon Koi',
                message: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripHtml: false
                }
            },
            'pdf', 'csv',
            {
                extend: 'excel',
                title: 'LAPORAN KONVERSI BARANG',
                messageTop: 'Tanggal: '+moment().format("DD/MM/YYYY") + '<br>' + message,
                exportOptions: {
                    stripNewlines: false
                },
                filename: function() {
                    var date_edition = moment().format("DDMMYYYY");
                    return  'Laporan Konversi Barang - ' + date_edition;
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