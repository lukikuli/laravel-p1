@extends('base')
@section('title', 'Pembelian')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Daftar Pembelian</h1>
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
            <a href="{{ route('pembelian.create') }}" class=" btn btn-sm btn-info">Add</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="MyTable">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Faktur</th>
                        <th>Tanggal Pembelian</th>
                        <th>Harga Total</th>
                        <th>Supplier</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->no_faktur }}</td>
                            <td>{{ date("d-M-Y", strtotime($data->tgl_beli)) }}</td>
                            <td>Rp {{ number_format($data->hrg_total) }}</td>
                            <td>{{ $data->supplier->nama }}</td>
                            <td>
                                <a href="{{ route('pembelian.show', encrypt($data->no_faktur)) }}" class=" btn btn-sm btn-info" target="_blank">Show</a>
                                <a href="{{ route('pembelian.printfaktur', [ 'id' => encrypt($data->no_faktur)]) }}" class=" btn btn-sm btn-primary" target="_blank">Print Faktur</a>
                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik')
                                    <form action="{{ route('pembelian.destroy', encrypt($data->no_faktur)) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-sm btn-link" type="submit" onclick="return confirm('Yakin ingin menghapus data?')">Delete</button>
                                    </form>
                                @endif
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