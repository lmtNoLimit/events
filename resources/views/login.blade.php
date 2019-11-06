<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- <base href="{{asset('./')}}"> -->
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.css' )}}" rel="stylesheet">
    <link href="{{ asset('css/custom.css' )}}" rel="stylesheet">
    <!-- Custom styles -->
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <main class="col-md-6 mx-sm-auto px-4">
            <div class="pt-3 pb-2 mb-3 border-bottom text-center">
                <h1 class="h2">MardSkills Event Platform</h1>
            </div>

            <form method="POST" class="form-signin">
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

                <label for="inputEmail" class="sr-only">Email</label>
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" autofocus>
                @if($errors->has('email'))
                    <p style="color:red">{{$errors->first('email')}}</p>
                @endif
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password">
                @if($errors->has('password'))
                    <p style="color:red">{{$errors->first('password')}}</p>
                @endif
                @if($errors->has('errorlogin'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{$errors->first('errorlogin')}}
                    </div>
                @endif
                {!! csrf_field() !!}
                <button class="btn btn-lg btn-primary btn-block" id="login" type="submit">Sign in</button>
            </form>

        </main>
    </div>
</div>
</body>
</html>
