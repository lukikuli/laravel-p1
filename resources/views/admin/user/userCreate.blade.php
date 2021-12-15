@extends('base')
@section('title', 'User')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Tambah User</h1>
            <hr>
            <form autocomplete="off" action="{{ route('user.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('nama') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('username') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('password') !!}</span>
                    @endif
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('role') !!}</span>
                    @endif
                    <select class="form-control" id="role" name="role">
                        <option value="pegawai" {{ old('role') == "pegawai" ? 'selected="selected"' : ''}}>Pegawai</option>
                        <option value="manager" {{ old('role') == "manager" ? 'selected="selected"' : ''}}>Manager</option>
                        <option value="pemilik" {{ old('role') == "pemilik" ? 'selected="selected"' : ''}}>Pemilik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nohp">No Hp:</label>
                    <input type="text" class="form-control" id="nohp" name="nohp" value="{{ old('nohp') }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" id="alamat" name="alamat">{{old('alamat')}}</textarea>
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