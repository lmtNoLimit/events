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

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{ route('events') }}">Manage Events</a></li>
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
            <li class="nav-item"><a class="nav-link active" href="{{route('chart', $event->id)}}">Room capacity</a></li>
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
            <h2 class="h4">Room Capacity</h2>
          </div>
        </div>

        <!-- TODO create chart here -->
        <script type="text/javascript" src="{{ asset('js/chartjs/dist/Chart.min.js') }}"></script>
        <div class="row">
          <div class="col-10">
            <canvas id="canvas"></canvas>
          </div>
        </div>

        <script>
          let event = {!! $event !!}

          let data = event.channels
            .flatMap(channel => channel.rooms)
            .map(room => ({
                sessions: room.sessions.map(session => ({
                  title: session.title,
                  capacity: room.capacity,
                  count: session.count,
                  color: session.count > room.capacity ? 'rgba(255, 0, 0, .5)' : 'rgba(0, 255, 0, .5)'
                }))
              }))
            .flatMap(room => room.sessions);

          let barChartData = {
            labels: data.map(session => session.title),
            datasets: [{
              label: 'Attendees',
              backgroundColor: data.map(session => session.color),
              borderWidth: 1,
              data: data.map(session => session.count) //attendees count
            }, {
              label: 'Capacity',
              backgroundColor: 'rgba(0, 0, 235, .5)',
              borderWidth: 1,
              data: data.map(session => session.capacity), // room capacity
            }]
          }

          window.onload = function() {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myBar = new Chart(ctx, {
              type: 'bar',
              data: barChartData,
              options: {
                responsive: true,
                legend: {
                  position: 'right',
                },
              }
            });
          };
        </script>
      </main>
    </div>
  </div>

</body>

</html>