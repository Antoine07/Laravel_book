@extends('layouts.master')

@section('content')
<p><a href="{{route('book.create')}}"><button type="button" class="btn btn-primary btn-lg">Ajouter un livre</button></a></p>
{{$books->links()}}
{{-- On inclut le fichier des messages retournés par les actions du contrôleurs BookController--}}
@include('back.book.partials.flash')
<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Authors</th>
            <th>Genre</th>
            <th>Date de publication</th>
            <th>Status</th>
            <th>Edition</th>
            <th>Show</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    @forelse($books as $book)
        <tr>
            <td><a href="{{route('book.edit', $book->id)}}">{{$book->title}}</a></td>
            <td>
            @forelse($book->authors as $author)
                {{$author->name}}
            @empty
            aucun auteur
            @endforelse
            </td>
            <td>{{$book->genre->name?? 'aucun genre' }}</td>
            <td>{{$book->created_at}}</td>
            <td>
                @if($book->status == 'published')
                <button type="button" class="btn btn-success">published</button>
                @else 
                <button type="button" class="btn btn-warning">unpublished</button>
                @endif
            </td>
            <td>
            <a href="{{route('book.edit', $book->id)}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
            <td>
                <a href="{{route('book.show', $book->id)}}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
            </td>
            <td>
            <form class="delete" method="POST" action="{{route('book.destroy', $book->id)}}">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <input class="btn btn-danger" type="submit" value="delete" >
            </form>
            </td>
        </tr>
    @empty
        aucun titre ...
    @endforelse
    </tbody>
</table>
{{$books->links()}}
@endsection 

@section('scripts')
    @parent
    <script src="{{asset('js/confirm.js')}}"></script>
@endsection