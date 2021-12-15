@extends('base')
@section('title', 'Barang')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Daftar Barang</h1>
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
            <a href="{{ route('barang.create') }}" class=" btn btn-sm btn-info">Add</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="MyTable">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Stok Minimal</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Satuan</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $no = 1; @endphp
                    @foreach($datas as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->kode }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->stok_min }}</td>
                            <td>{{ $data->stok }}</td>
                            <td>Rp {{ number_format($data->harga_beli) }}</td>
                            <td>Rp {{ number_format($data->harga_jual) }}</td>
                            <td>{{ $data->satuan_id != "" ? $data->satuan->nama_satuan : "" }}</td>
                            <td>{{ $data->jenis_id != "" ? $data->jenisbarang->jenis : "" }}</td>
                            <td>
                                <form action="{{ route('barang.destroy', $data->kode) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <a href="{{ route('barang.edit', encrypt($data->kode)) }}" class=" btn btn-sm btn-primary">Edit</a>
                                    <a href="{{ route('barang.show', encrypt($data->kode)) }}" class=" btn btn-sm btn-info">Show</a>
                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Yakin ingin menghapus data?')">Delete</button>
                                </form>
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