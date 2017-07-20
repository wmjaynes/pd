<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/">
        <img src="/images/pd_logo_white_300.gif" alt="PublicDrum" style='max-height: 40px;'>
    </a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a>
            </li>

            @if(Auth::check())
                @if(Auth::user()->organizations->isNotEmpty() or Auth::user()->superuser)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('events.index') }}">Events</a>
                    </li>
                @endif
                <li class="nav-item">
                        <a class="nav-link" href="/venue">Venues</a>
                    </li>
                <li class="nav-item">
                        <a class="nav-link" href="{{route('organization.index')}}">Organizations</a>
                    </li>
            @if (isset(Auth::user()->currentOrganization))
                    <li class="nav-item">
                            <a class="nav-link"
                               href="{{route('aggregate.index',['organization'=>Auth::user()->currentOrganization->id])}}">Aggregates</a>
                        </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->nameOrEmail() }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        <a class="dropdown-item" href="#">Account</a>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
            @endif

        </ul>
    </div>
</nav>