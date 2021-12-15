@extends('base')
@section('title', 'Dashboard')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>My Dashboard</h1>
            <hr>
            <h3>Hari ini</h3>
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-box-outline"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Pembelian</span>
                          <span class="info-box-number">{{ count($orders1) }}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-social-usd-outline"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Penjualan</span>
                          <span class="info-box-number">{{ count($sales1) }}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Customer</span>
                          <span class="info-box-number">{{ $pelanggans1 }}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-cart-outline"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Laba</span>
                          <span class="info-box-number">Rp {{ number_format($laba1) }}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <hr>
                <h3>Bulan ini</h3>
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion ion-ios-box-outline"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Pembelian</span>
                          <span class="info-box-number">{{ count($orders2) }}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-social-usd-outline"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Penjualan</span>
                          <span class="info-box-number">{{ count($sales2) }}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Customer</span>
                          <span class="info-box-number">{{ $pelanggans2 }}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-cart-outline"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Laba</span>
                          <span class="info-box-number">Rp {{ number_format($laba2) }}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                      <div class="box-header with-border">
                        <h3 class="box-title">Penjualan 6 Bulan terakhir</h3>

                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>

                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="row">
                          <div class="col-md-6">
                            <p class="text-center">
                              <strong>Jumlah Penjualan</strong>
                            </p>
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="nav-tabs-custom">
                              <div class="tab-content no-padding">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="sales-chart" style="position: relative; height: 300px;"></div>
                              </div>
                            </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <p class="text-center">
                              <strong>Laba Penjualan</strong>
                            </p>
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="nav-tabs-custom">
                              <div class="tab-content no-padding">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="sales2-chart" style="position: relative; height: 300px;"></div>
                              </div>
                            </div>
                        </div>
                        <!-- /.row -->
                      </div>
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">
                  <div class="col-md-8">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                      <div class="box-header with-border">
                        <h3 class="box-title">Transaksi Penjualan Terbaru</h3>

                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="table-responsive">
                          <table class="table no-margin">
                            <thead>
                            <tr>
                              <th>No. Faktur</th>
                              <th>Tanggal Penjualan</th>
                              <th>Harga Total</th>
                              <th>Pelanggan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($penjualans as $penjualan)
                                <tr>
                                    <td><a href="{{ route('penjualan.show', encrypt($penjualan->no_faktur)) }}" class="" target="_blank">{{ $penjualan->no_faktur }}</a></td>
                                    <td>{{ date("d-M-Y", strtotime($penjualan->tgl_jual)) }}</td>
                                    <td>Rp {{ number_format($penjualan->hrg_total) }}</td>
                                    <td>{{ $penjualan->pelanggan->nama }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.table-responsive -->
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer text-center">
                        <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-default btn-flat uppercase" target="_blank">Lihat Semua Penjualan</a>
                      </div>
                      <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <div class="col-md-4">
                    <!-- PRODUCT LIST -->
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title">Barang Yang Baru Ditambahkan</h3>

                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <ul class="products-list product-list-in-box">
                        @foreach($barangs as $barang)
                          <!-- /.item -->
                          <li class="item">
                            <div class="product-info">
                              <a href="javascript:void(0)" class="product-title">{{ $barang->kode }}
                                <span class="label label-info pull-right">Harga Jual Rp {{ number_format($barang->harga_jual) }}</span></a>
                              <span class="product-description">
                                {{ $barang->nama . " (". $barang->jenisbarang->jenis . ")" }}
                                <span class="label label-warning pull-right">Stok {{ $barang->stok ." (" . $barang->satuan->nama_satuan . ")" }}</span>
                              </span>
                            </div>
                          </li>
                        @endforeach
                        </ul>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer text-center">
                        <a href="{{ route('barang.index') }}" class="uppercase" target="_blank">Lihat Semua Barang</a>
                      </div>
                      <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                  </div>
                </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection
@push('custom-scripts')
<script>
  var morrisData = [];
  $(function() {
      // $.each(data, function(key, val){
      //     morrisData.push({'Bulan': key.bulan, 'Total' : key.sale_count}); 
      // });
      $.ajax({
          type   : 'POST',
          url    : '{{ url('/getPenjualanChart1') }}',
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          async  : true,
          dataType: 'json',
          encode  : true,
          success: function (response) {
              var morrisData = [];
            if(response.success)
            {
              for(var x=0; x<response.data.length; x++)
              {
                morrisData.push({'Bulan' : response.data[x].bulan, 'Total' : response.data[x].sale_count, 'Tahun' : response.data[x].tahun}); 
              }
              console.log(morrisData);
              new Morris.Bar({
                  element: 'sales-chart',
                  data: morrisData,
                  xkey: ['Bulan'],
                  ykeys: ['Total'],
                  labels: ['Penjualan Tahun '+morrisData[0]['Tahun']],
                  hideHover: 'auto',
                  resize: true
              });
            }
          }
      });
  });

  $(function() {
      // $.each(data, function(key, val){
      //     morrisData.push({'Bulan': key.bulan, 'Total' : key.sale_count}); 
      // });
      $.ajax({
          type   : 'POST',
          url    : '{{ url('/getPenjualanChart2') }}',
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          async  : true,
          dataType: 'json',
          encode  : true,
          success: function (response) {
            var morrisData1 = [];
            if(response.success)
            {
              for(var x=0; x<response.data.length; x++)
              {
                morrisData1.push({'Bulan': response.data[x].bulan, 'Total' : response.data[x].total, 'Tahun' : response.data[x].tahun}); 
              }
              console.log(morrisData1);
              new Morris.Bar({
                  element: 'sales2-chart',
                  data: morrisData1,
                  xkey: ['Bulan'],
                  ykeys: ['Total'],
                  labels: ['Laba Penjualan Tahun '+morrisData1[0]['Tahun']],
                  hideHover: 'auto',
                  resize: true
              });
            }
          }
      });
  });
//   new Morris.Line({
//   // ID of the element in which to draw the chart.
//   element: 'revenue-chart',
//   // Chart data records -- each entry in this array corresponds to a point on
//   // the chart.
//   data: [
//     { year: '2008', value: 15 },
//     { year: '2009', value: 10 },
//     { year: '2010', value: 5 },
//     { year: '2011', value: 5 },
//     { year: '2012', value: 20 }
//   ],
//   // The name of the data record attribute that contains x-values.
//   xkey: 'year',
//   // A list of names of data record attributes that contain y-values.
//   ykeys: ['value'],
//   // Labels for the ykeys -- will be displayed when you hover over the
//   // chart.
//   labels: ['Value']
// });
// Morris.Line({
//   element: 'line-example',
//   data: [
//     { y: '2006', a: 100, b: 90 },
//     { y: '2007', a: 75,  b: 65 },
//     { y: '2008', a: 50,  b: 40 },
//     { y: '2009', a: 75,  b: 65 },
//     { y: '2010', a: 50,  b: 40 },
//     { y: '2011', a: 75,  b: 65 },
//     { y: '2012', a: 100, b: 90 }
//   ],
//   xkey: 'y',
//   ykeys: ['a', 'b'],
//   labels: ['Series A', 'Series B']
// });

// Morris.Area({
//   element: 'area-example',
//   data: [
//     { y: '2006', a: 100, b: 90 },
//     { y: '2007', a: 75,  b: 65 },
//     { y: '2008', a: 50,  b: 40 },
//     { y: '2009', a: 75,  b: 65 },
//     { y: '2010', a: 50,  b: 40 },
//     { y: '2011', a: 75,  b: 65 },
//     { y: '2012', a: 100, b: 90 }
//   ],
//   xkey: 'y',
//   ykeys: ['a', 'b'],
//   labels: ['Series A', 'Series B']
// });
// Morris.Donut({
//   element: 'donut-example',
//   data: [
//     {label: "Download Sales", value: 12},
//     {label: "In-Store Sales", value: 30},
//     {label: "Mail-Order Sales", value: 20}
//   ]
// });
// Morris.Bar({
//   element: 'bar-example',
//   data: [
//     { y: '2006', a: 100, b: 90 },
//     { y: '2007', a: 75,  b: 65 },
//     { y: '2008', a: 50,  b: 40 },
//     { y: '2009', a: 75,  b: 65 },
//     { y: '2010', a: 50,  b: 40 },
//     { y: '2011', a: 75,  b: 65 },
//     { y: '2012', a: 100, b: 90 }
//   ],
//   xkey: 'y',
//   ykeys: ['a', 'b'],
//   labels: ['Series A', 'Series B']
// });
</script>
@endpush