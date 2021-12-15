@extends('base')
@section('title', 'User')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Edit User</h1>
            <hr>
            <form autocomplete="off" action="{{ route('user.update', $data->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('nama') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('username') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="username" name="username" value="{{ $data->username }}">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('password') !!}</span>
                    @endif
                    <input type="password" class="form-control" id="password" name="password" value="{{ $data->password }}">
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('role') !!}</span>
                    @endif
                    <select class="form-control" id="role" name="role">
                        <option value="pegawai" {{ $data->role == "pegawai" ? 'selected="selected"' : '' }}>Pegawai</option>
                        <option value="manager" {{ $data->role == "manager"? 'selected="selected"' : '' }}>Manager</option>
                        <option value="pemilik" {{ $data->role == "pemilik"? 'selected="selected"' : '' }}>Pemilik</option>
                        <option value="admin" {{ $data->role == "admin"? 'selected="selected"' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nohp">No Hp:</label>
                    <input type="text" class="form-control" id="nohp" name="nohp" value="{{ $data->nohp }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" id="alamat" name="alamat">{{$data->alamat}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    <a href="{{ route('user.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
            </form>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection