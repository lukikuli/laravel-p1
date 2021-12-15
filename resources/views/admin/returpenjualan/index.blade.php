@extends('base')
@section('title', 'Retur Penjualan')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Daftar Retur Penjualan</h1>
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
            <a href="{{ route('returpenjualan.create') }}" class=" btn btn-sm btn-info">Add</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="MyTable">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>No Retur</th>
                        <th>Tanggal Retur</th>
                        <th>Faktur Penjualan</th>
                        <th>Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $no = 1; @endphp
                    @foreach($datas as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->no_retur }}</td>
                            <td>{{ date("d-M-Y", strtotime($data->tgl_retur)) }}</td>
                            <td>{{ $data->faktur_penjualan }}</td>
                            <td>{{ $data->penjualan->pelanggan->nama }}</td>
                            <td>
                                <a href="{{ route('returpenjualan.show', encrypt($data->no_retur)) }}" class=" btn btn-sm btn-info">Show</a>
                                <a href="{{ route('returpenjualan.printfaktur', ['id' => encrypt($data->no_retur)]) }}" class=" btn btn-sm btn-primary" target="_blank">Print Retur</a>
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