@extends('base')
@section('title', 'Supplier')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Supplier Detail</h1>
            <hr>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <div class="form-control" id="nama" name="nama">{{ $data->nama }}</div>
                </div>
                <div class="form-group">
                    <label for="telp1">No Telp 1:</label>
                    <div class="form-control" id="telp1" name="telp1">{{ $data->telp_1 }}</div>
                </div>
                <div class="form-group">
                    <label for="telp2">No Telp 2:</label>
                    <div class="form-control" id="telp2" name="telp2">{{ $data->telp_2 }}</div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <div class="form-control" id="alamat" name="alamat">{{ $data->alamat }}</div>
                </div>
                <div class="form-group">
                    <label for="kota">Kota:</label>
                    <div class="form-control" id="kota" name="kota">{{ $data->kota }}</div>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan:</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" readonly="" rows="10">{{$data->keterangan}}</textarea>
                </div>
                <div class="form-group">
                    <a href="{{ route('supplier.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection