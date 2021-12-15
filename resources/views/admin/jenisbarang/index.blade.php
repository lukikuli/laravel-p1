@extends('base')
@section('title', 'Jenis Barang')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Daftar Jenis Barang</h1>
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
            <a href="{{ route('jenisbarang.create') }}" class=" btn btn-sm btn-info">Add</a>
            <table class="table table-bordered" id="MyTable">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @php $no = 1; @endphp
                @foreach($datas as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->jenis }}</td>
                        <td>
                            <form action="{{ route('jenisbarang.destroy', $data->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <a href="{{ route('jenisbarang.edit', encrypt($data->id)) }}" class=" btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('jenisbarang.show', encrypt($data->id)) }}" class=" btn btn-sm btn-info">Show</a>
                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Yakin ingin menghapus data?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection