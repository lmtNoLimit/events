<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/events">Event Platform</a>
    <span class="navbar-organizer w-100">{{$user->name}}</span>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" id="logout" href="/logout">Sign out</a>
        </li>
    </ul>
</nav>