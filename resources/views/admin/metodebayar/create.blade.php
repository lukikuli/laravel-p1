@extends('base')
@section('title', 'Metode Pembayaran')
@section('content')
    <!-- Main Section -->
    <section class="main-section">
        <!-- Add Your Content Inside -->
        <div class="content">
            <!-- Remove This Before You Start -->
            <h1>Tambah Metode Pembayaran</h1>
            <hr>
            <form autocomplete="off" action="{{ route('metodebayar.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="metode">Nama Metode:</label>
                    @if(count($errors) > 0)
                        <span class="label label-danger">{!! $errors->first('metode') !!}</span>
                    @endif
                    <input type="text" class="form-control" id="metode" name="metode" value="{{ old('metode') }}" maxlength="191">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    <a href="{{ route('metodebayar.index') }}" class="btn btn-md btn-danger">Back</a>
                </div>
            </form>
        </div>
        <!-- /.content -->
    </section>
    <!-- /.main-section -->
@endsection