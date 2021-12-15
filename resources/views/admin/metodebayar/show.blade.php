 @extends('base')
@section('title', 'Metode Pembayaran')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Metode Pembayaran Detail</h1>
            <hr>
                <div class="form-group">
                    <label for="metode">Nama Metode:</label>
                    <div class="form-control" id="metode" name="metode">{{ $data->nama_metode }}</div>
                </div>
                <div class="form-group">
                    <a href="{{ route('metodebayar.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection