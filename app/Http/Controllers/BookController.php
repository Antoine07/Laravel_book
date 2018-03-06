<?php

namespace App\Http\Controllers;

use Cache;
use Storage;
use App\Book;
use App\Genre;
use App\Author;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $paginate = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate($this->paginate);

        return view('back.book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.create', compact('authors', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $book = Book::create($request->all()); // associé les fillables

        $book->authors()->attach($request->authors);

        $this->uploadPicture($book, $request);

        //clear all cache
        Cache::flush();

        return redirect()->route('book.index')->with('message', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Book $book)
    {
        return view('back.book.show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Book $book)
    {

        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.edit', compact('book', 'authors', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookRequest|Request $request
     * @param Book $book
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->all());
        $book->authors()->sync($request->authors);
        
        $this->uploadPicture($book, $request);

        Cache::flush();

        return redirect()->route('book.index')->with('message', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Book $book)
    {
        $book->delete();

        Cache::flush();

        return redirect()->route('book.index')->with('message', 'success delete');
    }

    /**
     * method to update or delete picture
     * @param Book $book
     * @param Request $request
     */
    private function uploadPicture(Book $book, Request $request):void{

        if (!empty($request->file('picture'))) {

            $link = $request->file('picture')->store('./');

            if(!is_null($book->picture)){
                Storage::disk('local')->delete($book->picture->link);
                $book->picture()->delete();
            }

            $book->picture()->create([
                'link' => $link,
                'title' => $request->title_image?? $request->title
            ]);

            return ;

        }

        if(
            !is_null($book->picture)
            and isset( $request->title_image)
            and  $request->title_image != $book->picture->title){
            $book->picture()->update(['title' => $request->title_image]);
        }
    }
}
