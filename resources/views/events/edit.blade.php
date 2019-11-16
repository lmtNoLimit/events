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
                    <li class="nav-item"><a class="nav-link active" href="{{url('/events/'.$event->id)}}">Overview</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Reports</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link" href="{{url('/events/'.$event->id.'/report')}}">Room capacity</a></li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{$event->name}}</h1>
                </div>
            </div>

            <form action="{{ url('/events/'.$event->id) }}"" method="POST" class="needs-validation" novalidate>
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputName">Name</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        <input type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="inputName" 
                                placeholder=""
                                name="name"
                                value="{{$event->name}}">
                        <div class="invalid-feedback">
                            {{$errors->first('name')}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputSlug">Slug</label>
                        <input type="text" 
                                class="form-control @error('slug') is-invalid @enderror" 
                                id="inputSlug" 
                                placeholder="" 
                                name="slug"
                                value="{{$event->slug}}">
                    </div>
                    <div class="invalid-feedback">
                        {{$errors->first('slug')}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputDate">Date</label>
                        <input type="text"
                               class="form-control @error('date') is-invalid @enderror"
                               id="inputDate"
                               name="date"
                               placeholder="yyyy-mm-dd"
                               value="{{$event->date}}">
                    </div>
                    <div class="invalid-feedback">
                        {{$errors->first('date')}}
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ url('events/'. $event->id) }}" class="btn btn-link">Cancel</a>
            </form>

        </main>
    </div>
</div>

</body>
</html>
