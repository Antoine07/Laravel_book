@foreach($books as $book)
@foreach($book->authors as $author)
    {{ $author->name }}
@endforeach
@endforeach

