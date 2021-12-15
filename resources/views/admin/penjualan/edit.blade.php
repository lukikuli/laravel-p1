@extends('base')
@section('title', 'Supplier')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Edit Supplier</h1>
            <hr>
            <form action="{{ route('supplier.update', $data->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('nama') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}">
                </div>
                <div class="form-group">
                    <label for="telp">No Telp:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('telp') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="telp" name="telp" value="{{ $data->telp }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('alamat') !!}</span>
                    @endif
                    <textarea class="form-control" id="alamat" name="alamat">{{$data->alamat}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    <a href="{{ route('supplier.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
            </form>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection