<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="{{ url('img/koi_icon_E14_icon.ico') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | Dragon Koi</title>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    
    <!-- jQuery 3 -->
    <script src="{{url('assets/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{url('assets/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('assets/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url('assets/bower_components/Ionicons/css/ionicons.min.css')}}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{url('/css/login.css')}}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body>
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="{{ url('/loginPost') }}" method="post">
                            @csrf
                            <h3 class="text-center text-info">Login Dragon Koi Center</h3>
                             @if(\Session::has('alert'))
                                <div class="alert alert-danger">
                                    <div>{!! \Session::get('alert') !!}</div>
                                </div>
                            @endif
                            @if(\Session::has('alert-success'))
                                <div class="alert alert-success">
                                    <div>{!! \Session::get('alert-success') !!}</div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                @if(count($errors) > 0)
                                    <span class="label label-danger">{!! $errors->first('username') !!}</span>
                                @endif
                                <input type="text" name="username" id="username" class="form-control" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                @if(count($errors) > 0)
                                    <span class="label label-danger">{!! $errors->first('password') !!}</span>
                                @endif
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember" type="checkbox"></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>