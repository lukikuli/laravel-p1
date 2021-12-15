@extends('base')
@section('title', 'Barang')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Barang Detail</h1>
            <hr>
                <div class="form-group">
                    <label for="kode">Kode Barang:</label>
                    <div class="form-control" id="kode" name="kode">{{ $data->kode }}</div>
                </div>
                <div class="form-group">
                    <label for="jenis">Jenis Barang:</label>
                    <div class="form-control" id="jenis" name="jenis">{{ $data->jenis_id != "" ? $data->jenisbarang->jenis : "" }}</div>
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <div class="form-control" id="nama" name="nama">{{ $data->nama }}</div>
                </div>
                <div class="form-group">
                    <label for="stokmin">Stok Minimal:</label>
                    <div class="form-control" id="stokmin" name="stokmin">{{ $data->stok_min }}</div>
                </div>
                <div class="form-group">
                    <label for="stok">Stok:</label>
                    <div class="form-control" id="stok" name="stok">{{ $data->stok }}</div>
                </div>
                <div class="form-group">
                    <label for="beli">Harga Beli: (Rp)</label>
                    <div class="form-control" id="beli" name="beli">Rp {{ number_format($data->harga_beli) }}</div>
                </div>
                <div class="form-group">
                    <label for="jual">Harga Jual: (Rp)</label>
                    <div class="form-control" id="jual" name="jual">Rp {{ number_format($data->harga_jual) }}</div>
                </div>
                <div class="form-group">
                    <label for="satuan">Satuan Barang:</label>
                    <div class="form-control" id="satuan" name="satuan">{{ $data->satuan_id != "" ? $data->satuan->nama_satuan : "" }}</div>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan:</label>
                    <div class="form-control" id="keterangan" name="keterangan">{{ $data->keterangan }}</div>
                </div>
                <div class="form-group">
                    <a href="{{ route('barang.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection