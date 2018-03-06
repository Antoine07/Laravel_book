@extends('layouts.master')

@section('content')
<article class="row">
    <div class="col-md-12">
    @if(!is_null($book))
    <h1>{{$book->title}}</h1>
    @if(!empty($book->picture))
        <div class="col-xs-6 col-md-12">
            <a href="#" class="thumbnail">
            <img src="{{asset('images/'.$book->picture->link)}}" alt="{{$book->picture->title}}">
            </a>
        </div>
    @endif
    <h2>Description :</h2>
    {{$book->description}}    
    @if(count($book->scores)>0)
    <p>Moyenne des votes {{round($book->scores()->avg('vote'),1)}}</p>
    @endif
    <h3>Auteur(s) :</h3>
    <ul>
        @forelse($book->authors as $author)
        <li >{{$author->name}}</li>
        @empty
        <li>Aucun auteur</li>
        @endforelse
    </ul>
    @if($lock)
    yes
    @else 
    no
    @endif
    <h2>Voter pour ce livre :</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(Session::has('message'))
    <div class="alert">
        <p>{{Session::get('message')}}</p>
    </div>
    @endif
    <form action="{{route('vote')}}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="book_id" value="{{$book->id}}">
        <input type="hidden" name="ip" value="{{request()->ip()}}">        
        <select name="vote" >
        @for ($i = 1; $i < 6; $i++)
            <option value="{{$i}}">{{$i}}</option>
        @endfor
        </select>
        <p><input type="submit" value="ok"></p>
    </form>
    @else 
    <h1>Désolé aucun article</h1>
    @endif 
 </li>
    </div>
</article>

</ul>
@endsection 

