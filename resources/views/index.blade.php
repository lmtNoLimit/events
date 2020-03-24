<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Event Backend</title>

  <base href="./">
  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <!-- Custom styles -->
  <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body>

  <div class="container-fluid">
    <div class="row">
      <main class="col-md-6 mx-sm-auto px-4">
        <div class="pt-3 pb-2 mb-3 border-bottom text-center">
          <h1 class="h2">MardSkills Event Platform</h1>
        </div>

        <form class="form-signin" method="POST" action="/login">
          <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
          @csrf

          @if($message = Session::get('error'))
          <div class="alert alert-danger">
            {{$message}}
          </div>
          @endif
          <label for="inputEmail" class="sr-only">Email</label>
          <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" autofocus
            value="{{ old('email') }}" required>

          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password"
            required>
          <button class="btn btn-lg btn-primary btn-block" id="login" type="submit">Sign in</button>
        </form>

      </main>
    </div>
  </div>
</body>

</html>