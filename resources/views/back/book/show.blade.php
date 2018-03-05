@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6">
        <h1><strong>title</strong> :{{$book->title}}</h1>
        <p><strong>Genre :</strong>{{$book->genre->name?? 'aucun'}}</p>
        <p><strong>Date de création : </strong> : {{$book->created_at}}</p>
        <p><strong>Date de mise à jour : </strong> : {{$book->updated_at}}</p>
        <p><strong>Status :</strong> : TODO</p>
        <h2>Les auteurs :</h2>
        <ul>
            <li><strong>Nombre d'auteur(s) </strong>: {{count($book->authors)}}</li>
        @forelse($book->authors as $author)
            <li>{{$author->name}}</li>
        @empty
        aucun auteur
        @endforelse
        </ul>
    </div>
    <div class="col-md-6">
    <h2><strong>Image</strong></h2>
    @if(!empty($book->picture))
        <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
            <img src="{{asset('images/'.$book->picture->link)}}" alt="{{$book->picture->title}}">
            </a>
        </div>
    @endif
    </div>
</div>
@endsection 