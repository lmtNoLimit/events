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
  @include('navbar')

  <div class=" container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="{{route('events')}}">Manage Events</a></li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div
          class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Manage Events</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <a href="{{ route('createEvent') }}" class="btn btn-sm btn-outline-secondary">Create new event</a>
            </div>
          </div>
        </div>

        <div class="row events">
          @foreach($events as $event)
          <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
              <a href="{{ route('eventDetail', $event->id) }}" class="btn text-left event">
                <div class="card-body">
                  <h5 class="card-title">{{$event->name}}</h5>
                  <p class="card-subtitle">{{date("F j, Y", strtotime($event->date))}}</p>
                  <hr>
                  <p class="card-text">{{number_format($event->registrations, 0)}} registrations</p>
                </div>
              </a>
            </div>
          </div>
          @endforeach
        </div>

      </main>
    </div>
  </div>

</body>

</html>