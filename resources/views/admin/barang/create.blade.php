@extends('base')
@section('title', 'Barang')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Tambah Barang</h1>
            <hr>
            <form autocomplete="off" action="{{ route('barang.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="kode">Kode Barang:</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="{{ $kode }}" readonly maxlength="30">
                </div>
                <div class="form-group">
                    <label for="jenis">Jenis Barang:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('jenis') !!}</span>
                    @endif
                    <select class="form-control" id="jenis" name="jenis" autofocus>
                        <option value="" selected disabled>Pilih Jenis</option>
                        @foreach($jenisbarangs as $jenisbarang)
                            <option value="{{ $jenisbarang->id }}" {{ old('jenis') == $jenisbarang->id ? 'selected=selected' : ''}}>{{$jenisbarang->jenis}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="barcode">Barcode:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('barcode') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="barcode" name="barcode" value="{{ old('barcode') }}" maxlength="191">
                </div>
                <div class="form-group">
                    <label for="nama">Nama Barang:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('nama') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" maxlength="191">
                </div>
                <div class="form-group">
                    <label for="stokmin">Stok Minimal:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('stokmin') !!}</span>
                    @endif
                    <input type="number" class="form-control" id="stokmin" name="stokmin" value="{{ old('stokmin') }}">
                </div>
                <div class="form-group">
                    <label for="stok">Stok:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('stok') !!}</span>
                    @endif
                    <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok') }}">
                </div>
                <div class="form-group">
                    <label for="beli">Harga Beli: (Rp)</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('beli') !!}</span>
                    @endif
                    <input type="text" class="form-control separator" id="beli" name="beli" value="{{ old('beli') }}" maxlength="14">
                </div>
                <div class="form-group">
                    <label for="jual">Harga Jual: (Rp)</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('jual') !!}</span>
                    @endif
                    <input type="text" class="form-control separator" id="jual" name="jual" value="{{ old('jual') }}" maxlength="14">
                </div>
                <div class="form-group">
                    <label for="satuan">Satuan Barang:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('satuan') !!}</span>
                    @endif
                    <select class="form-control" id="satuan" name="satuan">
                        <option value="" selected disabled>Pilih Satuan</option>
                        @foreach($satuans as $satuan)
                            <option value="{{ $satuan->id }}" {{ old('satuan') == $satuan->id ? 'selected=selected' : ''}}>{{$satuan->nama_satuan}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan:</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" maxlength="700">{{old('keterangan')}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
            </form>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection