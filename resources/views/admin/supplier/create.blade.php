@extends('base')
@section('title', 'Supplier')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Tambah Supplier</h1>
            <hr>
            <form autocomplete="off" action="{{ route('supplier.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('nama') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" maxlength="191">
                </div>
                <div class="form-group">
                    <label for="telp1">No. Telp 1:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('telp1') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="telp1" name="telp1" value="{{ old('telp1') }}" maxlength="191">
                </div>
                <div class="form-group">
                    <label for="telp2">No. Telp 2:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('telp2') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="telp2" name="telp2" value="{{ old('telp2') }}" maxlength="191">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('alamat') !!}</span>
                    @endif
                    <textarea class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}" maxlength="191">{{old('alamat')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="kota">Kota:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('kota') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="kota" name="kota" value="{{ old('kota') }}" maxlength="191">
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('keterangan') !!}</span>
                    @endif
                    <textarea class="form-control" id="keterangan" name="keterangan" maxlength="700" rows="10">{{old('keterangan')}}</textarea>
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