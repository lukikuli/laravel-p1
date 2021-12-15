@extends('base')
@section('title', 'Konversi Barang')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Konversi Barang</h1>
            <form action="{{ route('konversi.store') }}" method="post">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="tgl_konversi">Tanggal Konversi :</label>
                        <input type="date" class="form-control" id="tgl_konversi" name="tgl_konversi" value="{{ date('Y-m-d') }}">
                    </div> 
                </div>
                <div class="col-md-6">
                <h3 class="box-title">Data Barang Keluar</h3>
                    <div class="form-group">
                        <label for="jenis1">Pilih Jenis Barang:</label>
                        @if(count($errors) > 0)
                            <span class="label label-danger">{!! $errors->first('jenis1') !!}</span>
                        @endif
                        <select class="form-control select2" id="jenis1" name="jenis1" autofocus>
                            <option value="" selected disabled>Pilih Jenis</option>
                            @foreach($jenisbarangs as $jenisbarang)
                                <option value="{{ $jenisbarang->id }}" {{ old('jenis1') == $jenisbarang->id ? 'selected=selected' : ''}}>{{$jenisbarang->jenis}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="barang1">Pilih Barang:</label>
                        @if(count($errors) > 0)
                            <span class="label label-danger">{!! $errors->first('barang1') !!}</span>
                        @endif
                        <select class="form-control select2" id="barang1" name="barang1">
                            <option value="" selected disabled>Pilih Barang</option>
                            @foreach($barangs as $barang)
                                @if($barang->jenis_id == old('jenis1'))
                                    <option value="{{ $barang->kode }}" {{ old('barang1') == $barang->kode ? 'selected=selected' : ''}}>{{$barang->nama}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok:</label>
                        <input type="text" class="form-control" id="stok1" name="stok1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="satuan1">Satuan Barang:</label>
                        <input type="text" class="form-control" id="satuan1" name="satuan1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stok_keluar">Jumlah Stok Keluar :</label>
                        @if(count($errors) > 0)
                            <span class="label label-danger">{!! $errors->first('stok_keluar') !!}</span>
                        @endif
                        <input type="number" class="form-control" id="stok_keluar" name="stok_keluar" min="1" value="{{ old('stok_keluar') }}">
                    </div>
                </div>
                <div class="col-md-6">
                <h3 class="box-title">Data Barang Masuk</h3>
                    <div class="form-group">
                        <label for="jenis2">Pilih Jenis Barang:</label>
                        @if(count($errors) > 0)
                            <span class="label label-danger">{!! $errors->first('jenis2') !!}</span>
                        @endif
                        <select class="form-control select2" id="jenis2" name="jenis2">
                            <option value="" selected disabled>Pilih Jenis</option>
                            @foreach($jenisbarangs as $jenisbarang)
                                <option value="{{ $jenisbarang->id }}" {{ old('jenis2') == $jenisbarang->id ? 'selected=selected' : ''}}>{{$jenisbarang->jenis}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="barang2">Pilih Barang:</label>
                        @if(count($errors) > 0)
                            <span class="label label-danger">{!! $errors->first('barang2') !!}</span>
                        @endif
                        <select class="form-control select2" id="barang2" name="barang2">
                            <option value="" selected disabled>Pilih Barang</option>
                            @foreach($barangs as $barang)
                                @if($barang->jenis_id == old('jenis2'))
                                    <option value="{{ $barang->kode }}" {{ old('barang2') == $barang->kode ? 'selected=selected' : ''}}>{{$barang->nama}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok:</label>
                        <input type="text" class="form-control" id="stok2" name="stok2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="satuan2">Satuan Barang:</label>
                        <input type="text" class="form-control" id="satuan2" name="satuan2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stok_masuk">Jumlah Stok Masuk :</label>
                        @if(count($errors) > 0)
                            <span class="label label-danger">{!! $errors->first('stok_masuk') !!}</span>
                        @endif
                        <input type="number" class="form-control" id="stok_masuk" name="stok_masuk" min="1" value="{{ old('stok_masuk') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary">Submit</button>
                        <a href="{{ route('konversi.index') }}" class="btn btn-md btn-danger">Back</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection

@push('custom-scripts')
<script>   
var rowNum = 0;
$(document).ready(function() { 
    $("#stok_keluar").numericInput({ allowFloat: true, allowNegative: false });
    $("#stok_masuk").numericInput({ allowFloat: true, allowNegative: false });
});

$(document).on('change', '#jenis1', function() {  
    var jenis = $('#jenis1').val();
        $('#barang1').find('option').remove();
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxJenisBrg') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { jenis : jenis },
        async  : false,
        dataType: 'json',
        encode  : true,
        success: function (response) {
            if(response.success)
            {
                $("#barang1").select2({placeholder: "Pilih Barang"});
                $('#barang1').append($("<option selected disabled></option>").attr("value","").text(""));
                for(var x=0; x<response.data.length; x++)
                    $('#barang1').append("<option value='"+response.data[x].kode+"'>"+response.data[x].nama+"</option>");
            }
            else
            {
                alert('Barang tidak ditemukan. Refresh atau coba lagi');
            }
            $('#barang1').focus();
        },
        error: function (response) {
            var url = location.pathname;
            window.location = url;
        }
    });
});
$(document).on('change', '#barang1', function() {  
    var kode = $(this).val();
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAJaxKodeBarang') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { kode : kode },
        async  : false,
        dataType: 'json',
        encode  : true,
        success: function (response) {
            if(response.success)
            {
                $('#stok1').val(response.data.stok);
                $('#satuan1').val(response.data.satuan.nama_satuan);
                $('#stok_keluar').attr("max", response.data.stok);
            }
            $('#stok_keluar').focus();
        },
        error: function (response) {
            // var url = location.pathname;
            // window.location = url;
        }
    });
});
$(document).on('change', '#jenis2', function() {  
    var jenis = $('#jenis2').val();
        $('#barang2').find('option').remove();
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAjaxJenisBrg') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { jenis : jenis },
        async  : false,
        dataType: 'json',
        encode  : true,
        success: function (response) {
            if(response.success)
            {
                $("#barang2").select2({placeholder: "Pilih Barang"});
                $('#barang2').append($("<option selected disabled></option>").attr("value","").text(""));
                for(var x=0; x<response.data.length; x++)
                    $('#barang2').append("<option value='"+response.data[x].kode+"'>"+response.data[x].nama+"</option>");
            }
            else
            {
                alert('Barang tidak ditemukan. Refresh atau coba lagi');
            }
            $('#barang1').focus();
        },
        error: function (response) {
            var url = location.pathname;
            window.location = url;
        }
    });
});
$(document).on('change', '#barang2', function() {  
    var kode = $(this).val();
    $.ajax({
        type   : 'POST',
        url    : '{{ url('/getAJaxKodeBarang') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data   : { kode : kode },
        async  : false,
        dataType: 'json',
        encode  : true,
        success: function (response) {
            if(response.success)
            {
                $('#stok2').val(response.data.stok);
                $('#satuan2').val(response.data.satuan.nama_satuan);
            }
        }
    });
});
</script>
@endpush