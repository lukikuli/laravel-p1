@extends('base')
@section('title', 'Manajemen Penjualan')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Manajemen Penjualan</h1>
            <hr>

            <form action="{{ route('laporan.index') }}" method="get">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mulai Tanggal</label>
                            <input type="date" name="start_date" class="form-control {{ $errors->has('start_date') ? 'is-invalid':'' }}" id="start_date" value="{{ request()->get('start_date') }}">
                        </div>
                        <div class="form-group">
                            <label for="">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control {{ $errors->has('end_date') ? 'is-invalid':'' }}" id="end_date" value="{{ request()->get('end_date') }}">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pelanggan">Pelanggan</label>
                            <select name="pelanggan" class="form-control">
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($customers as $cust)
                                <option value="{{ $cust->id }}"
                                    {{ request()->get('pelanggan') == $cust->id ? 'selected':'' }}>
                                    {{ $cust->nama }} - {{ $cust->telp }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user">Pegawai</label>
                            <select name="user" class="form-control">
                                <option value="">Pilih Pegawai</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request()->get('user') == $user->id ? 'selected':'' }}>
                                    {{ $user->nama }} - {{ $user->nohp }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>


            <!-- FORM UNTUK MENAMPILKAN DATA TRANSAKSI -->
            <div class="col-md-12">
                <!-- KOTAK UNTUK MENAMPILKAN TOTAL DATA -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $sold }}</h3>
                                <p>Item Terjual</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>Rp {{ number_format($total) }}</h3>
                                <p>Total Omset</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $total_customer }}</h3>
                                <p>Total pelanggan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                <!-- TABLE UNTUK MENAMPILKAN DATA TRANSAKSI -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Faktur</th>
                                <th>Tanggal Penjualan</th>
                                <th>Pelanggan</th>
                                <th>No Telp</th>
                                <th>Total Belanja</th>
                                <th>Metode Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- LOOPING MENGGUNAKAN FORELSE, DIRECTIVE DI LARAVEL 5.6 -->
                            @forelse ($orders as $row)
                            <tr>
                                <td><strong>{{ $row->no_faktur }}</strong></td>
                                <td>{{ date('d-m-Y', strtotime($row->tgl_jual)) }}</td>
                                <td>{{ $row->pelanggan_id != "" ? $row->pelanggan->nama : "" }}</td>
                                <td>{{ $row->pelanggan_id != "" ? $row->pelanggan->telp : "" }}</td>
                                <td>Rp {{ number_format($row->hrg_total) }}</td>
                                <td>{{ $row->metode->nama_metode }}</td>
                                <td>
                                    <a href="{{ route('laporan.pdf', ['invoice' => $row->no_faktur]) }}" 
                                        target="_blank"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <a href="{{ route('laporan.excel', $row->no_faktur) }}" 
                                        target="_blank"
                                        class="btn btn-info btn-sm">
                                        <i class="fa fa-file-excel-o"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="7">Tidak ada data transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection

@push('custom-scripts')
<script>
        $('#start_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
​
        $('#end_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
</script>
@endpush