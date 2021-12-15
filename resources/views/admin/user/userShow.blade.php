@extends('base')
@section('title', 'User')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>User Detail</h1>
            <hr>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <div class="form-control" id="nama" name="nama">{{ $data->nama }}</div>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <div class="form-control" id="username" name="username">{{ $data->username }}</div>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <div class="form-control" id="role" name="role">{{ $data->role }}</div>
                </div>
                <div class="form-group">
                    <label for="nohp">No Hp:</label>
                    <div class="form-control" id="nohp" name="nohp">{{ $data->nohp }}</div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <div class="form-control" id="alamat" name="alamat">{{ $data->alamat }}</div>
                </div>
                <div class="form-group">
                    <a href="{{ route('user.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection