<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LARAVEL CMS</title>

    <link href="backend/css/bootstrap.min.css" rel="stylesheet">
    <link href="backend/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="backend/css/animate.css" rel="stylesheet">
    <link href="backend/css/style.css" rel="stylesheet">
    <link href="backend/css/customize.css" rel="stylesheet">


</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">Welcome to Ktech</h2>

                <p>
                    Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app
                    views.
                </p>


            </div>
            <div class="col-md-6">
                <div class="ibox-content">



                    <form method="post" class="m-t" role="form" action="{{ route('auth.login') }}">
                        @csrf
                        <div class="form-group">
                            <input name='email' type="text" class="form-control" placeholder="Email"
                                value="{{ old('email', ($user->email) ?? '' ) }}">

                            {{-- show lỗi ra nếu có --}}
                            @if ($errors->has('email'))
                            <span class="error-message">
                                * {{ $errors->first('email')}}
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name='password' type="password" class="form-control" placeholder="Password">
                            {{-- show lỗi ra nếu có --}}
                            @if ($errors->has('password'))
                            <span class="error-message">
                                * {{ $errors->first('password')}}
                            </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary block full-width m-b">Đăng nhập</button>

                        <a href="#">
                            <small>Forgot password?</small>
                        </a>


                    </form>
                    <p class="m-t">
                        <small>NewBie 2024</small>
                    </p>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Copyright Example Company
            </div>
            <div class="col-md-6 text-right">
                <small>© 2024</small>
            </div>
        </div>
    </div>

</body>

</html>