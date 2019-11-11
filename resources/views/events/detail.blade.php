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
                    <li class="nav-item"><a class="nav-link" href="/events">Manage Events</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{ $event->name }}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="{{url('/events/'.$event->id)}}">Overview</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Reports</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link" href="reports/index.html">Room capacity</a></li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            @include('partials.flash_message')
            <div class="border-bottom mb-3 pt-3 pb-2 event-title">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{$event->name}}</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ url('events/'. $event->id . '/edit') }}" class="btn btn-sm btn-outline-secondary">Edit event</a>
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
                            <a href="{{ url('/events/'.$event->id.'/tickets/create')}}" class="btn btn-sm btn-outline-secondary">
                                Create new ticket
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row tickets">
                @foreach($tickets as $key => $data)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{$data->name}}</h5>
                            <p class="card-text">{{$data->cost}}</p>
                            <p class="card-text">
                            <?php 
                                $special_validity = json_decode($data->special_validity, TRUE);
                                $special_info = "";
                                if(isset($special_validity['type'])) {
                                    if($special_validity['type'] === "date") {
                                        $special_info = "Available ultil ".date('F j, Y', strtotime($special_validity['date']));
                                    } else {
                                        if($special_validity['amount'] == 1) {
                                            $special_info = $special_validity['amount']." ticket available";
                                        } else {
                                            $special_info = $special_validity['amount']." tickets available";
                                        }
                                    }
                                } else {
                                    $special_info = NULL;
                                }
                            ?>
                                {{ $special_info }}
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
                            <a href="{{ url('/events/'.$event->id.'/sessions/create') }}" class="btn btn-sm btn-outline-secondary">
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
                    @foreach($sessions as $key => $data)
                    <tr>
                        <td class="text-nowrap">
                            {{date("H:i", strtotime($data->start)).' - '.date("H:i", strtotime($data->end))}}
                        </td>
                        <td>{{ucfirst($data->type)}}</td>
                        <td><a href="{{ url('/events/'.$event->id.'/sessions/'.$data->id).'/edit' }}">{{$data->title}}</a></td>
                        <td class="text-nowrap">{{$data->speaker}}</td>
                        <td class="text-nowrap">
                            {{"$data->channel_name / $data->room_name"}}
                        <td>
                    </tr>
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
                            <a href="{{url('/events/'.$event->id.'/channels/create')}}" class="btn btn-sm btn-outline-secondary">
                                Create new channel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row channels">
            @foreach($channels as $key => $data)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{$data->name}}</h5>
                            <p class="card-text">1 Session, 2 Rooms
                                <!-- "$data->session_count sessions, $data->room_count rooms" -->
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
                            <a href="{{ url('/events/'.$event->id.'/rooms/create') }}" class="btn btn-sm btn-outline-secondary">
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
                    @foreach($rooms as $key => $data)
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>{{$data->capacity}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

</body>
</html>
