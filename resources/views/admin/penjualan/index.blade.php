@extends('base')
@section('title', 'Penjualan')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Daftar Penjualan</h1>
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
            <a href="{{ route('penjualan.create') }}" class=" btn btn-sm btn-info">Add</a>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="MyTable">
                    <thead>
                    <tr>
                        <th>Faktur</th>
                        <th>Tanggal Penjualan</th>
                        <th>Harga Total</th>
                        <th>Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr>
                            <td><a href="{{ route('penjualan.show', encrypt($data->no_faktur)) }}" target="_blank">{{ $data->no_faktur }}</a></td>
                            <td>{{ date("d-M-Y", strtotime($data->tgl_jual)) }}</td>
                            <td>Rp {{ number_format($data->hrg_total) }}</td>
                            <td>{{ $data->pelanggan_id != "" ? $data->pelanggan->nama : "" }}</td>
                            <td>
                                <a href="{{ route('penjualan.show', encrypt($data->no_faktur)) }}" class=" btn btn-sm btn-info" target="_blank">Show</a>
                                <a href="{{ route('penjualan.printfaktur', ['id' => encrypt($data->no_faktur)]) }}" class=" btn btn-sm btn-primary" target="_blank">Print Faktur</a>
                                <a href="{{ route('penjualan.printsuratjalan', ['id' => encrypt($data->no_faktur)]) }}" class=" btn btn-sm btn-danger" target="_blank">Print Surat Jalan</a>
                                <a href="{{ route('penjualan.printthermal', ['id' => encrypt($data->no_faktur)]) }}" class=" btn btn-sm btn-success" target="_blank">Print Thermal</a>
                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik')
                                    <form action="{{ route('penjualan.destroy', encrypt($data->no_faktur)) }}" method="post">
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