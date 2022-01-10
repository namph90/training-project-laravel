<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap.min.css') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container" style="width: 500px; margin-top: 200px;">
    <form method="post" action="{{ route('login') }}">
        @csrf
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">LOGIN</h2>
            </div>
            @if (session()->has('login_err'))
                <div style="color: red">{{ trans('messages.login_err') }}</div>
            @endif
            @if (session()->has('login_err_blank'))
                <div style="color: red">{{ trans('messages.login_required') }}</div>
            @endif
            <div class="panel-body">
                <p class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email"
                           value="{{session()->has('value_old') ? session()->get('value_old')['email'] : ""}}">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" name="password" placeholder="Enter Password">
            </div>
            <button class="btn btn-success" type="submit" name="submit">Login</button>
        </div>
    </form>
</div>

</div>
</body>
</html>

