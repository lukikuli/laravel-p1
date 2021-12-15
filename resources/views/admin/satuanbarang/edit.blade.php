@extends('base')
@section('title', 'Satuan Barang')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Edit Satuan Barang</h1>
            <hr>
            <form autocomplete="off" action="{{ route('satuanbarang.update', $data->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Satuan:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('nama') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama_satuan }}" maxlength="191">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    <a href="{{ route('satuanbarang.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
            </form>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection