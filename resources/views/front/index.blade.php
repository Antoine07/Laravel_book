@extends('layouts.master')

@section('content')
<h1>Tous les livres</h1>
{{$books->links()}}
<ul class="list-group">
@forelse($books as $book)
<li class="list-group-item">
<h2><a href="{{url('book', $book->id)}}">{{$book->title}}</a></h2>
@if(count($book->scores)>0)
<p>Moyenne des votes {{round($book->scores()->avg('vote'),1)}}</p>
@endif
<div class="row">
@if(!empty($book->picture))
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
            <img width="171" src="{{asset('images/'.$book->picture->link)}}" alt="{{$book->picture->title}}">
            </a>
        </div>
@endif
<div class="col-xs-6 col-md-9">
{{$book->description}}
</div>
</div>
<h3>Auteur(s) :</h3>
    <ul>
        @forelse($book->authors as $author)
        <li ><a href="{{url('author', $author->id)}}">{{$author->name}}</a></li>
        @empty
        <li>Aucun auteur</li>
        @endforelse
    </ul>
 </li>
@empty
<li>Désolé pour l'instant aucun livre n'est publié sur le site</li>
@endforelse
</ul>
{{$books->links()}}
@endsection 

