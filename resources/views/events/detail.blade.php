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
            <li class="nav-item"><a class="nav-link" href="/events">Manage Events</a></li>
          </ul>

          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>{{$event->name}}</span>
          </h6>
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="{{route('eventDetail', $event->id)}}">Overview</a>
            </li>
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
        <div class="border-bottom mb-3 pt-3 pb-2 event-title">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h1 class="h2">{{$event->name}}</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <a href="{{route('updateEvent', $event->id)}}" class="btn btn-sm btn-outline-secondary">Edit event</a>
              </div>
            </div>
          </div>
          <span class="h6">{{date("F j, Y", strtotime($event->date))}}</span>
        </div>

        <!-- Tickets -->
        <div id="tickets" class="mb-3 pt-3 pb-2">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h2 class="h4">Tickets</h2>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <a href="{{route('createTicket', $event->id)}}" class="btn btn-sm btn-outline-secondary">
                  Create new ticket
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="row tickets">
          @foreach($event->tickets as $ticket)
          <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
              <div class="card-body">
                <h5 class="card-title">{{$ticket->name}}</h5>
                <p class="card-text">{{$ticket->cost}}</p>
                <p class="card-text">
                  <?php $special_validity = json_decode($ticket->special_validity); ?>
                  @if(isset($special_validity))
                  @if($special_validity->type == 'date')
                  Available util {{date("F j, Y", strtotime($special_validity->date))}}
                  @else
                  {{$special_validity->amount}} tickets
                  @endif
                  @endif
                </p>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Sessions -->
        <div id="sessions" class="mb-3 pt-3 pb-2">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h2 class="h4">Sessions</h2>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <a href="{{route('createSession', $event->id)}}" class="btn btn-sm btn-outline-secondary">
                  Create new session
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive sessions">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Time</th>
                <th>Type</th>
                <th class="w-100">Title</th>
                <th>Speaker</th>
                <th>Channel</th>
              </tr>
            </thead>
            <tbody>
              @foreach($event->channels as $channel)
              @foreach($channel->rooms as $room)
              @foreach($room->sessions as $session)
              <tr>
                <td class="text-nowrap">
                  {{date("h:i", strtotime($session->start))}} - {{date("h:i", strtotime($session->end))}}
                </td>
                <td class="text-capitalize">{{$session->type}}</td>
                <td><a href="{{route('editSession', [$event->id, $session->id])}}">{{$session->title}}</a></td>
                <td class="text-nowrap">{{$session->speaker}}</td>
                <td class="text-nowrap">{{$channel->name}}/{{$room->name}}</td>
              </tr>
              @endforeach
              @endforeach
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Channels -->
        <div id="channels" class="mb-3 pt-3 pb-2">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h2 class="h4">Channels</h2>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <a href="{{route('createChannel', $event->id)}}" class="btn btn-sm btn-outline-secondary">
                  Create new channel
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="row channels">
          @foreach($event->channels as $channel)
          <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
              <div class="card-body">
                <h5 class="card-title">{{$channel->name}}</h5>
                <p class="card-text">
                  @php
                  $rooms = $channel->rooms->count();
                  $sessions_count = 0;
                  foreach($channel->rooms as $room) {
                  $sessions = $room->sessions->count();
                  $sessions_count = $sessions;
                  }
                  @endphp
                  {{$sessions_count == 1 ? "$sessions_count session" : "$sessions_count sessions"}},
                  {{$rooms == 1 ? "$rooms room" : "$rooms rooms"}}
                </p>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Rooms -->
        <div id="rooms" class="mb-3 pt-3 pb-2">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h2 class="h4">Rooms</h2>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <a href="{{route('createRoom', $event->id)}}" class="btn btn-sm btn-outline-secondary">
                  Create new room
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive rooms">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Capacity</th>
              </tr>
            </thead>
            <tbody>
              @foreach($event->channels as $channel)
              @foreach($channel->rooms as $room)
              <tr>
                <td>{{$room->name}}</td>
                <td>{{$room->capacity}}</td>
              </tr>
              @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>

</html>