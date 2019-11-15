<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Event Backend</title>

    <!-- <base href="../"> -->
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.css' )}}" rel="stylesheet">
    <link href="{{ asset('css/custom.css' )}}" rel="stylesheet">
</head>

<body>
@include('partials.navbar')

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="events/index.html">Manage Events</a></li>
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
                    <li class="nav-item"><a class="nav-link active" href="reports/index.html">Room capacity</a></li>
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
            <script src="{{ asset('js/chart.js/dist/Chart.bundle.min.js') }}"></script>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <canvas id="canvas" height="400" width="900"></canvas>
                    </div>
                </div>
            </div>
            <script>
                let data = {!! $data !!}
                let sessions = data.map(item => item.title);
                let attendeeBgColor = data.map(item => {
                    if(item.attendee_count > item.room_capacity) {
                        return 'rgba(201, 44, 65, 0.93)';
                    }
                    return 'rgba(173, 235, 153, 1)';
                });
                let barChartData = {
                    labels: sessions,
                    datasets: [{
                        label: 'Attendees',
                        backgroundColor: attendeeBgColor,
                        borderWidth: 1,
                        data: data.map(item => item.attendee_count)
                    }, {
                        label: 'Capacity',
                        backgroundColor: 'rgba(153, 187, 235, 1)',
                        borderWidth: 1,
                        data: data.map(item => item.room_capacity)
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
