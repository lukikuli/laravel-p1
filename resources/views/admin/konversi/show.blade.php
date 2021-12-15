@extends('base')
@section('title', 'Konversi Barang')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Konversi Barang</h1>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="tgl_konversi">Tanggal Konversi :</label>
                        <div class="form-control" id="tgl_konversi" name="tgl_konversi">{{ $data->tgl_konversi }}</div>
                    </div> 
                </div>
                <div class="col-md-6">
                <h3 class="box-title">Data Barang Keluar</h3>
                    <div class="form-group">
                        <label for="jenis1">Jenis Barang:</label>
                        <div class="form-control" id="jenis1" name="jenis1">{{ $data->barangkeluar->jenisbarang->jenis }}</div>
                    </div>
                    <div class="form-group">
                        <label for="barang1">Barang:</label>
                        <div class="form-control" id="barang1" name="barang1">{{ $data->barangkeluar->nama }}</div>
                    </div>
                    <div class="form-group">
                        <label for="satuan1">Satuan Barang:</label>
                        <div class="form-control" id="satuan1" name="satuan1">{{ $data->barangkeluar->satuan->nama_satuan }}</div>
                    </div>
                    <div class="form-group">
                        <label for="stok_keluar">Jumlah Stok Keluar :</label>
                        <div class="form-control" id="stok_keluar" name="stok_keluar">{{ $data->stok_keluar }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                <h3 class="box-title">Data Barang Masuk</h3>
                    <div class="form-group">
                        <label for="jenis2">Jenis Barang:</label>
                        <div class="form-control" id="jenis2" name="jenis2">{{ $data->barangmasuk->jenisbarang->jenis }}</div>
                    </div>
                    <div class="form-group">
                        <label for="barang2">Barang:</label>
                        <div class="form-control" id="barang2" name="barang2">{{ $data->barangmasuk->nama }}</div>
                    </div>
                    <div class="form-group">
                        <label for="satuan2">Satuan Barang:</label>
                        <div class="form-control" id="satuan2" name="satuan2">{{ $data->barangmasuk->satuan->nama_satuan }}</div>
                    </div>
                    <div class="form-group">
                        <label for="stok_masuk">Jumlah Stok Masuk :</label>
                        <div class="form-control" id="stok_masuk" name="stok_masuk">{{ $data->stok_masuk }}</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <a href="{{ route('konversi.index') }}" class="btn btn-md btn-danger">Back</a>
                    </div>
                </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection