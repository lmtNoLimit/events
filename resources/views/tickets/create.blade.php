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
                    <span>{{$event->name}}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{url('/events/'.$event->id)}}">Overview</a></li>
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
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{$event->name}}</h1>
                </div>
                <span class="h6">{{$event->date}}</span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Create new ticket</h2>
                </div>
            </div>

            <form action="{{url('/events/'.$event->id.'/tickets')}}" method="POST" class="needs-validation" novalidate>
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputName">Name</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        <input type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="inputName" 
                                name="name" 
                                placeholder="" 
                                value="{{old('name')}}">
                        <div class="invalid-feedback">
                            {{$errors->first('name')}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputCost">Cost</label>
                        <input type="number" 
                                class="form-control @error('cost') is-invalid @enderror" 
                                id="inputCost" 
                                name="cost" 
                                placeholder="" 
                                value="{{old('cost') != 0 ? old('cost') : 0}}">
                        <div class="invalid-feedback">
                            {{$errors->first('cost')}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectSpecialValidity">Special Validity</label>
                        <select
                            class="form-control" 
                            id="selectSpecialValidity" 
                            name="special_validity">
                            <option value="" selected>None</option>
                            <option value="amount">Limited amount</option>
                            <option value="date">Purchaseable till date</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputAmount">Maximum amount of tickets to be sold</label>
                        <input type="number" 
                                class="form-control @error('amount') is-invalid @enderror" 
                                id="inputAmount" 
                                name="amount" 
                                placeholder=""
                                value="{{old('amount') != 0 ? old('amount') : 0}}">
                        <div class="invalid-feedback">
                            {{$errors->first('amount')}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputValidTill">Tickets can be sold until</label>
                        <input type="text"
                               class="form-control @error('date') is-invalid @enderror"
                               id="inputValidTill"
                               name="date"
                               placeholder="yyyy-mm-dd HH:MM"
                               value="{{old('date')}}">
                        <div class="invalid-feedback">
                            {{$errors->first('date')}}
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary" type="submit">Save ticket</button>
                <a href="{{ url('events/'.$event->id) }}" class="btn btn-link">Cancel</a>
            </form>

        </main>
    </div>
</div>

</body>
</html>
