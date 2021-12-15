 @extends('base')
@section('title', 'Satuan Barang')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Satuan Barang Detail</h1>
            <hr>
                <div class="form-group">
                    <label for="nama">Nama Satuan:</label>
                    <div class="form-control" id="nama" name="nama">{{ $data->nama_satuan }}</div>
                </div>
                <div class="form-group">
                    <a href="{{ route('satuanbarang.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection