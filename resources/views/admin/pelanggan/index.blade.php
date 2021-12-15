@extends('base')
@section('title', 'Customer')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Daftar Customer</h1>
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
            <a href="{{ route('pelanggan.create') }}" class=" btn btn-sm btn-info">Add</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="MyTable">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>No. Telp</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $no = 1; @endphp
                    @foreach($datas as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>{{ $data->kota }}</td>
                            <td>{{ $data->telp_1 }} / {{ $data->telp_2 }}</td>
                            <td>
                                <form action="{{ route('pelanggan.destroy', $data->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <a href="{{ route('pelanggan.edit', encrypt($data->id)) }}" class=" btn btn-sm btn-primary">Edit</a>
                                    <a href="{{ route('pelanggan.show', encrypt($data->id)) }}" class=" btn btn-sm btn-info">Show</a>
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