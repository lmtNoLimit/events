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
            <li class="nav-item"><a class="nav-link" href="{{route("eventDetail", $event->id)}}">Overview</a></li>
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
            <h2 class="h4">Create new session</h2>
          </div>
        </div>

        <form class="needs-validation" novalidate action="{{action("SessionController@store", $event->id)}}"
          method="POST">
          @csrf
          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <label for="selectType">Type</label>
              <select class="form-control" id="selectType" name="type">
                <option value="talk" selected>Talk</option>
                <option value="workshop">Workshop</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <label for="inputTitle">Title</label>
              <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
              <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" id="inputTitle"
                name="title" placeholder="" value="{{old('title')}}">
              @if($errors->has('title'))
              <div class="invalid-feedback">
                Title is required.
              </div>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <label for="inputSpeaker">Speaker</label>
              <input type="text" class="form-control @if($errors->has('speaker')) is-invalid @endif" id="inputSpeaker"
                name="speaker" placeholder="" value="{{old('speaker')}}">
              @if($errors->has('speaker'))
              <div class="invalid-feedback">
                Speaker is required
              </div>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <label for="selectRoom">Room</label>
              <select class="form-control" id="selectRoom" name="room">
                @foreach($event->channels as $channel)
                @foreach($channel->rooms as $room)
                <option value="{{$room->id}}" {{old('room') == $room->id ? 'selected' : ''}}>
                  {{$room->name}}
                </option>
                @endforeach
                @endforeach
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <label for="inputCost">Cost</label>
              <input type="number" class="form-control" id="inputCost" name="cost" placeholder=""
                value="{{old('cost', 0)}}">
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-lg-6 mb-3">
              <label for="inputStart">Start</label>
              <input type="text" class="form-control @if($errors->has('start')) is-invalid @endif" id="inputStart"
                name="start" placeholder="yyyy-mm-dd HH:MM" value="{{old('start')}}">
              @if($errors->has('start'))
              <div class="invalid-feedback">
                Start time is required
              </div>
              @endif
            </div>
            <div class="col-12 col-lg-6 mb-3">
              <label for="inputEnd">End</label>
              <input type="text" class="form-control @if($errors->has('end')) is-invalid @endif" id="inputEnd"
                name="end" placeholder="yyyy-mm-dd HH:MM" value="{{old('end')}}">
              @if($errors->has('end'))
              <div class="invalid-feedback">
                End time is required
              </div>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-3">
              <label for="textareaDescription">Description</label>
              <textarea class="form-control @if($errors->has('description')) is-invalid @endif" id="textareaDescription"
                name="description" placeholder="" rows="5">{{old('description')}}</textarea>
              @if($errors->has('description'))
              <div class="invalid-feedback">
                Description is required
              </div>
              @endif
            </div>
          </div>

          <hr class="mb-4">
          <button class="btn btn-primary" type="submit">Save session</button>
          <a href="{{route('eventDetail', $event->id)}}" class="btn btn-link">Cancel</a>
        </form>

      </main>
    </div>
  </div>

</body>

</html>