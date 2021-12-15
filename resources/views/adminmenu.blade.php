
<ul class="sidebar-menu" data-widget="tree">
    <li>
      <a href="{{ url('home') }}">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="{{ route('penjualan.create') }}"><i class="fa fa-dollar"></i><span>Kasir</span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-laptop"></i> <span>Master Data</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{ url('admin/user') }}"><i class="fa fa-circle-o"></i>User</a></li>
        <li><a href="{{ url('admin/pelanggan') }}"><i class="fa fa-circle-o"></i>Customer</a></li>
        <li><a href="{{ url('admin/supplier') }}"><i class="fa fa-circle-o"></i>Supplier</a></li>
        <li><a href="{{ url('admin/jenisbarang') }}"><i class="fa fa-circle-o"></i>Jenis Barang</a></li>
        <li><a href="{{ url('admin/barang') }}"><i class="fa fa-circle-o"></i>Barang</a></li>
        <li><a href="{{ url('admin/satuanbarang') }}"><i class="fa fa-circle-o"></i>Satuan Barang</a></li>
        <li><a href="{{ url('admin/metodebayar') }}"><i class="fa fa-circle-o"></i>Metode Pembayaran</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-shopping-cart"></i>
        <span>Transaksi</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{ url('admin/konversi') }}"><i class="fa fa-circle-o"></i>Konversi Barang</a></li>
        <li><a href="{{ url('admin/pembelian') }}"><i class="fa fa-circle-o"></i>Pembelian</a></li>
        <li><a href="{{ url('admin/returpembelian') }}"><i class="fa fa-circle-o"></i>Retur Pembelian</a></li>
        <li><a href="{{ url('admin/penjualan') }}"><i class="fa fa-circle-o"></i>Penjualan</a></li>
        <li><a href="{{ url('admin/returpenjualan') }}"><i class="fa fa-circle-o"></i>Retur Penjualan</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-pie-chart"></i> <span>Laporan</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{ route('laporanstokbarang') }}"><i class="fa fa-circle-o"></i>Laporan Stok Barang</a></li>
        <li><a href="{{ route('laporankonversibarang') }}"><i class="fa fa-circle-o"></i>Laporan Konversi Barang</a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-circle-o"></i> Laporan Pembelian
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('laporanpembelian.detail') }}"><i class="fa fa-circle-o"></i> By Detail</a></li>
            <li><a href="{{ route('laporanpembelian.supplier') }}"><i class="fa fa-circle-o"></i> By Supplier</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-circle-o"></i> Laporan Penjualan
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('laporanpenjualan.detail') }}"><i class="fa fa-circle-o"></i> By Detail</a></li>
            <li><a href="{{ route('laporanpenjualan.metode') }}"><i class="fa fa-circle-o"></i> By Metode Pembayaran</a></li>
            <li><a href="{{ route('laporanpenjualan.pelanggan') }}"><i class="fa fa-circle-o"></i> By Pelanggan</a></li>
          </ul>
        </li>
        <li><a href="{{ route('laporanreturpembelian.detail') }}"><i class="fa fa-circle-o"></i>Laporan Retur Pembelian</a></li>
        <li><a href="{{ route('laporanreturpenjualan.detail') }}"><i class="fa fa-circle-o"></i>Laporan Retur Penjualan</a></li>
      </ul>
    </li>
  </ul>