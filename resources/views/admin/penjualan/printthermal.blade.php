<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Faktur Penjualan | Dragon KOi</title>
  <link rel="icon" href="{{ url('img/koi_icon_E14_icon.ico') }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:light,regular,medium,thin,italic,mediumitalic,bold" rel="stylesheet">  
  
  <style>
    @media print {
      html, body {
        height: auto;
        /*font-family: 'Roboto Slab';font-size: 16px; font-weight: 400;*/
        /*font-family: 'Roboto'; font-weight:medium;*/
        font-weight: bold;
        margin-right: auto;
        margin-bottom: auto;
        margin-left: 0;
        margin-top: -2px;
        -webkit-transform: translate3d(0,0,0) !important;
        transform: translate3d(0,0,0) !important;
      
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
      }
    }/*
    @media print {
        .page-break { display: block; page-break-before: always; }
    }*/
    .info img {
      -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
      filter: grayscale(100%);
    }   
    #invoice-POS {
      height: auto;
      box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
      /*padding: 2mm;*/
      margin: 0 auto;
      width: 58mm;
      background: #FFF;
    }
    #invoice-POS ::selection {
      background: #f31544;
      color: #FFF;
    }
    #invoice-POS ::moz-selection {
      background: #f31544;
      color: #FFF;
    }
    #invoice-POS h1 {
      font-size: 1.5em;
      color: #222;
    }
    #invoice-POS h2 {
      font-size: 1em;
      margin-top: 0px;
      margin-bottom: 0px;
    }
    #invoice-POS h3 {
      font-size: 1.3em;
      font-weight: 300;
      line-height: 2em;
    }
    #invoice-POS p {
      /*font-size: .7em;*/
      line-height: 1.2em;
    }
    #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
      /* Targets all id with 'col-' */
      border-bottom: 1px solid #EEE;
    }
    #invoice-POS #top {
      min-height: 50px;
    }
    #invoice-POS #mid {
      min-height: 45px;
    }
    #invoice-POS #bot {
      min-height: 125px;
    }
    #invoice-POS #top .logo {
      /*height: 20px;
      width: 20px;
      background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
      background-size: 20px 20px;*/
    }
    #invoice-POS .info {
      display: block;
      margin-left: 0;
      margin-top: 10px;
    }
    #invoice-POS .tabletitle p {
      text-align: right;
    }
    #invoice-POS table {
      width: 100%;
      border-collapse: collapse;
    }
    #invoice-POS .tabletitle {
      /*font-size: .8em;*/
    }
    #invoice-POS .service {
      border-bottom: 1px solid #EEE;
    }
    #invoice-POS .item {
      width: 23mm;
    }
    #invoice-POS .payment {
      text-align: right;
    }
    #invoice-POS .itemtext {
      font-size: .9em;
    }
    #invoice-POS .legal {
      font-size: .7em;
      text-align: center;
    }
    #invoice-POS #legalcopy {
      margin-top: 5mm;
    }
  </style>
</head>

<body onload="window.print();" translate="no" >
  <div id="invoice-POS">
    <center id="top">
      <div class="logo"></div>
      <div class="info"> 
        <!-- <h3>DRAGON KOI CENTER</h3> -->
        <img src="{{ url('img/koi logo bw.PNG') }}" style="max-width:219px;">
      </div><!--End Info-->
    </center><!--End InvoiceTop-->

    <div id="mid">
      <div class="info">
        {{ date('d-M-Y H:i:s') }}
        @if(!is_null($data->pelanggan))
        <p>
          Customer: {{ $data->pelanggan->nama }}<br>
          {{ $data->pelanggan->alamat }}. {{ $data->pelanggan->kota }}<br>
          Telp : {{ $data->pelanggan->telp_1 }} {{ $data->pelanggan->telp_2 != '' ? ' / '.$data->pelanggan->telp_2 : '' }}
        </p>
        @endif
      </div>
    </div><!--End Invoice Mid-->
    <div id="bot">
      <div id="table">
          <table>
              <tr class="tabletitle">
                  <td class="item"><h2><strong>Item</strong></h2></td>
                  <td class="Hours"><h2><strong>Qty</strong></h2></td>
                  <td class="Rate payment"><h2><strong>Subtotal</strong></h2></td>
              </tr>

              @foreach($details as $detail)
              <tr class="service">
                  <td class="tableitem"><p class="itemtext">{{ $detail->barang->nama }}</p></td>
                  <td class="tableitem"><p class="itemtext">{{ $detail->jmlh }}</p></td>
                  <td class="tableitem payment"><p class="itemtext">Rp {{ number_format($detail->subtotal) }}</p></td>
              </tr>
              @endforeach
              <tr class="tabletitle">
                  <td></td>
                  <td class="Rate"><h2>Total</h2></td>
                  <td class="payment"><h2>Rp {{ number_format($data->hrg_total) }}</h2></td>
              </tr>
              <tr class="tabletitle">
                  <td></td>
                  <td class="Rate"><h2>Bayar</h2></td>
                  <td class="payment"><h2>Rp {{ number_format($data->bayar) }}</h2></td>
              </tr>
              <tr class="tabletitle">
                  <td></td>
                  <td class="Rate"><h2>Kembali</h2></td>
                  <td class="payment"><h2>Rp {{ number_format($data->kembali) }}</h2></td>
              </tr>

          </table>
      </div><!--End Table-->

      <div id="legalcopy">
        <center><h2>Terima Kasih</h2></center>
        <p class="legal">
          Green Ville Blok L no. 1. Jakarta Barat 11510<br>
          Telp : 021-5674758/59. Fax  : 021-5686564
        </p>
      </div>

  </div><!--End InvoiceBot-->
  </div><!--End Invoice-->
</body>
</html>