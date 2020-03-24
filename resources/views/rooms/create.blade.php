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
            <li class="nav-item"><a class="nav-link" href="{{route('events')}}">Manage Events</a></li>
          </ul>

          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>{{$event->name}}</span>
          </h6>
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{route('eventDetail', $event->id)}}">Overview</a></li>
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
          <span class="h6">{{date('F j, Y', strtotime($event->date))}}</span>
        </div>

        <div class="mb-3 pt-3 pb-2">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h2 class="h4">Create new room</h2>
          </div>
        </div>

        <form class="needs-validation" novalidate action="{{action('RoomController@store', $event->id)}}" method="POST">
          @csrf
          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <label for="inputName">Name</label>
              <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
              <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="inputName"
                name="name" placeholder="" value="{{ old('name') }}">
              @if($errors->has('name'))
              <div class="invalid-feedback">
                Name is required.
              </div>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <label for="selectChannel">Channel</label>
              <select class="form-control @if($errors->has('channel')) is-invalid @endif" id="selectChannel"
                name="channel">
                @foreach($event->channels as $channel)
                <option value="{{$channel->id}}" {{old('channel') == $channel->id ? 'selected' : ''}}>{{$channel->name}}
                </option>
                @endforeach
              </select>
              @if($errors->has('channel'))
              <div class="invalid-feedback">
                No channel has choose.
              </div>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <label for="inputCapacity">Capacity</label>
              <input type="number" class="form-control @if($errors->has('capacity')) is-invalid @endif"
                id="inputCapacity" name="capacity" placeholder="" value="">
              @if($errors->has('capacity'))
              <div class="invalid-feedback">
                Capacity is required.
              </div>
              @endif
            </div>
          </div>

          <hr class="mb-4">
          <button class="btn btn-primary" type="submit">Save room</button>
          <a href="{{ route('eventDetail', $event->id) }}" class="btn btn-link">Cancel</a>
        </form>

      </main>
    </div>
  </div>

</body>

</html>