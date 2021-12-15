@extends('base')
@section('title', 'Barang')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Edit Barang</h1>
            <hr>
            <form autocomplete="off" action="{{ route('barang.update', $data->kode) }}" method="post">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="kode">Kode Barang:</label>
                    <div class="form-control" id="kode" name="kode">{{ $data->kode }}</div>
                </div>
                <div class="form-group">
                    <label for="jenis">Jenis Barang:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('jenis') !!}</span>
                    @endif
                    <select class="form-control" id="jenis" name="jenis" autofocus>
                        <option value="" selected disabled>Pilih Jenis</option>
                        @foreach($jenisbarangs as $jenisbarang)
                            <option value="{{ $jenisbarang->id }}" {{ $jenisbarang->id == $data->jenis_id ? 'selected=selected' : ''}}>{{$jenisbarang->jenis}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="barcode">Barcode:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('barcode') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="barcode" name="barcode" value="{{ $data->barcode }}" maxlength="191">
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('nama') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}" maxlength="191">
                </div>
                <div class="form-group">
                    <label for="stokmin">Stok Minimal:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('stokmin') !!}</span>
                    @endif
                    <input type="number" class="form-control" id="stokmin" name="stokmin" value="{{ $data->stok_min }}">
                </div>
                <div class="form-group">
                    <label for="stok">Stok:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('stok') !!}</span>
                    @endif
                    <input type="number" class="form-control" id="stok" name="stok" value="{{ $data->stok }}">
                </div>
                <div class="form-group">
                    <label for="beli">Harga Beli: (Rp)</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('beli') !!}</span>
                    @endif
                    <input type="text" class="form-control separator" id="beli" name="beli" value="{{ $data->harga_beli }}" maxlength="14">
                </div>
                <div class="form-group">
                    <label for="jual">Harga Jual: (Rp)</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('jual') !!}</span>
                    @endif
                    <input type="text" class="form-control separator" id="jual" name="jual" value="{{ $data->harga_jual }}" maxlength="14">
                </div>
                <div class="form-group">
                    <label for="satuan">Satuan Barang:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('satuan') !!}</span>
                    @endif
                    <select class="form-control" id="satuan" name="satuan">
                        <option value="" selected disabled>Pilih Satuan</option>
                        @foreach($satuans as $satuan)
                            <option value="{{ $satuan->id }}" {{ $data->satuan_id == $satuan->id ? 'selected=selected' : ''}}>{{$satuan->nama_satuan}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan:</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" maxlength="700">{{$data->keterangan}}</textarea>
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