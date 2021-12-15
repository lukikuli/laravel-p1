@extends('base')
@section('title', 'Jenis Barang')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Tambah Jenis Barang</h1>
            <hr>
            <form autocomplete="off" action="{{ route('jenisbarang.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="jenis">Jenis:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('jenis') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="jenis" name="jenis" value="{{ old('jenis') }}" autofocus maxlength="191">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    <a href="{{ route('jenisbarang.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
            </form>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection