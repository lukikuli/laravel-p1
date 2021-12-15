@extends('base')
@section('title', 'Jenis Barang')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Jenis Barang Detail</h1>
            <hr>
                <div class="form-group">
                    <label for="jenis">Jenis:</label>
                    <div class="form-control" id="jenis" name="jenis">{{ $data->jenis }}</div>
                </div>
                <div class="form-group">
                    <a href="{{ route('jenisbarang.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection