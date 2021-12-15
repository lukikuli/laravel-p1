@extends('base')
@section('title', 'Konversi Barang')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Daftar Konversi Barang</h1>
            @if(Session::has('alert-success'))
                <div class="alert alert-success">
                    <strong>{{ \Illuminate\Support\Facades\Session::get('alert-success') }}</strong>
                </div>
            @endif
            @if(Session::has('alert-danger'))
                <div class="alert alert-danger">
                    <strong>{{ \Illuminate\Support\Facades\Session::get('alert-danger') }}</strong>
                </div>
            @endif
            <hr>
            <a href="{{ route('konversi.create') }}" class=" btn btn-sm btn-info">Add</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="MyTable">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Konversi</th>
                        <th>Barang Keluar</th>
                        <th>Stok Keluar</th>
                        <th>Barang Masuk</th>
                        <th>Stok Masuk</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date("d-M-Y", strtotime($data->tgl_konversi)) }}</td>
                            <td>{{ $data->barangkeluar->kode." - ".$data->barangkeluar->nama }}</td>
                            <td>{{ $data->stok_keluar }}</td>
                            <td>{{ $data->barangmasuk->kode." - ".$data->barangmasuk->nama }}</td>
                            <td>{{ $data->stok_masuk }}</td>
                            <td>
                                <a href="{{ route('konversi.show', encrypt($data->id)) }}" class=" btn btn-sm btn-info">Show</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection