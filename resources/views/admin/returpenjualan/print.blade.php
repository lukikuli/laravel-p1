<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Print Retur Penjualan | Dragon KOi</title>
  <link rel="icon" href="{{ url('img/koi_icon_E14_icon.ico') }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:light,regular,medium,thin,italic,mediumitalic,bold" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('assets/dist/css/AdminLTE.min.css')}}">
  
  <style>
    table {
      border: none !important;
    }
    thead th, tbody td {
      border: 1px solid black !important;
    }
    table tr th:first-child {
      width: 10%;
    }
    thead tr:first-child td {
      border: none !important;
    }
    .header-page {
      position: fixed;
      top: 0;
      width: 100%;
      height: 15px;
    }
    .header-space {
      height: 20px;
      width: 100%;
    }
    .page-footer-space {
      height: 100px;
      border: none !important;
    }

    .page-footer {
      height: 100px;
      position: fixed;
      bottom: 0;
      width: 100%;
      padding-right: 15px;
    }
    .page-footer strong {
      bottom: 39px;
      right: 0;
      position: absolute;
      padding-right: 30px;
    }
    .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
      padding: 2px !important;
    }

    img {
      display: block;
      margin-left: auto;
      margin-right: auto;
      max-height: 140px;
    }
    .nopadding {
       padding: 0 !important;
       margin: 0 !important;
    }
    @page {
      margin: 20mm
    }
    /*@page {
      margin-top: 20mm;
    }*/

    @media print {
       
     body {
        margin: 0;
        padding-top: 17px;
        padding-left: 15px;
        padding-right: 15px;
      }
      table { page-break-inside:auto }
      tr    { page-break-inside:avoid; page-break-after:auto }
      thead {display: table-header-group;} 
      tfoot {display: table-footer-group;}

      .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
        padding: 2px !important;
      }
    }
  </style>
</head>
<body onload="window.print();">
  <div class="row">
    <!-- /.col -->
    <div class="col-xs-4 pull-left">
      <p style="margin:0px; line-height:20px;">
        <strong>DRAGON KOI CENTER<br>
        Green Ville Blok L no. 1<br>
        Jakarta Barat 11510<br>
        Telp : 021-5674758/59<br>
        Fax  : 021-5686564</strong>
      </p>
    </div>
    <div class="col-xs-4">
        <img src="{{ url('img/koi logo.png') }}" style="margin-top: 20px;">
    </div>
    <!-- /.col -->
    <div class="col-xs-4 pull-right">
      <p style="margin:0px; line-height:20px; margin-left: 50px;">
        <strong>RETUR PENJUALAN</strong><br>
        Tanggal: {{ date('d-M-Y') }}<br>
        @if(!is_null($data->penjualan->pelanggan))
          Kepada Yth.<br>
            {{ $data->penjualan->pelanggan->nama }}<br>
            {{ $data->penjualan->pelanggan->alamat .", ". $data->penjualan->pelanggan->kota }}<br>
            Telp : {{ $data->penjualan->pelanggan->telp_1 }} {{ $data->penjualan->pelanggan->telp_2 != null ? ", ". $data->penjualan->pelanggan->telp_2 : ""}}<br>
        @endif
      </p>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-xs-6 pull-left">
        <div class="col-xs-5">No. Faktur</div><div class="col-xs-7">: {{ $data->penjualan->no_faktur }}</div>
        <div class="col-xs-5">Tanggal Faktur</div><div class="col-xs-7">: {{ date('d-M-Y', strtotime($data->penjualan->tgl_jual)) }}</div>
        <div class="col-xs-5">No. Retur</div><div class="col-xs-7">: {{ $data->no_retur }}</div>
      </div>
    </div>
  </div>

  <!-- Table row -->
  <div class="row">
    <div class="col-xs-12 table-responsive">
      <table class="table mytable">
        <thead>
        <tr>
          <td colspan="4"><div class="header-space">&nbsp;</div></td>
        </tr>
        <tr>
          <th style="width: 15%;">KODE</th>
          <th style="width: 70%;">NAMA</th>
          <th style="width: 15%;">QTY</th>
        </tr>
        </thead>
        <tbody>
        @foreach($details as $detail)
          <tr>
              <td>{{ $detail->kode_barang }}</td>
              <td>{{ $detail->barang->nama }}</td>
              <td>{{ $detail->jmlh_retur }}</td>
          </tr>
        @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4">
              <!--place holder for the fixed-position footer-->
              <div class="page-footer-space"></div>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <div class="row">
    <div class="col-xs-12 pull-left">
      <strong>Keterangan:</strong> {{ $data->keterangan }}
    </div>
    <!-- /.col -->
  </div>
  <div class="header-page"></div>
  <div class="page-footer">
    <strong class="pull-right">{{ Auth::user()->nama }}</strong>
  </div>
  </body>
</html>