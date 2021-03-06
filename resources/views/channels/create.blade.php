<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Event Backend</title>

  <base href="../">
  <!-- Bootstrap core CSS -->
  <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
  <!-- Custom styles -->
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>

<body>
  @include('message')
  @include('navbar')

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{route('events') }}">Manage Events</a></li>
          </ul>

          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>{{$event->name}}</span>
          </h6>
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="events/detail.html">Overview</a></li>
          </ul>

          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Reports</span>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item"><a class="nav-link" href="{{route('chart', $event->id)}}">Room capacity</a></li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="border-bottom mb-3 pt-3 pb-2">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h1 class="h2">{{$event->name}}</h1>
          </div>
          <span class="h6">{{date("F j, Y", strtotime($event->date))}}</span>
        </div>

        <div class="mb-3 pt-3 pb-2">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h2 class="h4">Create new channel</h2>
          </div>
        </div>

        <form class="needs-validation" novalidate action="{{action('ChannelController@store', $event->id)}}"
          method="POST">
          @csrf
          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <label for="inputName">Name</label>
              <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
              <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="inputName"
                name="name" placeholder="" value="">
              @if($errors->has('name'))
              <div class="invalid-feedback">
                Name is required.
              </div>
              @endif
            </div>
          </div>

          <hr class="mb-4">
          <button class="btn btn-primary" type="submit">Save channel</button>
          <a href="{{route("eventDetail", $event->id)}}" class="btn btn-link">Cancel</a>
        </form>

      </main>
    </div>
  </div>

</body>

</html>