<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"><a href="{{route('home')}}">Aucceil</a></span>
                @if(Route::is('book.*') == false)
                @forelse($genres as $id => $name)
                <span class="icon-bar"><a href="{{url('genre', $id)}}">{{$name}}</a></span>
                @empty 
                <li>Aucun genre pour l'instant</li>
                @endforelse
                @endif
            </button>
            <a class="navbar-brand" href="#">{{config('app.name')}}</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{route('home')}}">Aucceil</a></li>
                @if(Route::is('book.*') == false)
                @forelse($genres as $id => $name)
                <li ><a href="{{route('genre_book', $id)}}">{{$name}}</a></li>
                @empty 
                <li>Aucun genre pour l'instant</li>
                @endforelse
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
            {{-- renvoie true si vous êtes connecté --}}
                @if(Auth::check())
                <li><a href="{{route('book.index')}}">Dashboard</a></li> 
                <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>  
                @else 
                <li><a href="{{route('login')}}">Login</a></li>   
                @endif
            </ul>
        </div>
    </div>
</nav>