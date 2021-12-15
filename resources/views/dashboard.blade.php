@extends('base')
@section('title', 'Dashboard Pegawai')

@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Hello you are on staff dashboard</h1>
                <div>{{ Auth::user()->role }}<br> {{ Auth::user()->nama }}
                </div>
            <hr>
            
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection