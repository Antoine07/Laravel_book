<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Author;
use App\Genre;

use Storage;

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

        return view('back.book.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // permet de récupérer une collection type array avec en clé id => name
        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.create', ['authors' => $authors, 'genres' => $genres]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors.*' => 'integer', // pour vérifier un tableau d'entiers il faut mettre authors.*
            'status' => 'in:published,unpublished',
            'title_image' => 'string|nullable', // pour le titre de l'image si il existe
            'picture' => 'image|max:3000',
        ]);

        $book = Book::create($request->all()); // associé les fillables

        // On utilise le modèle Book et la relation authors ManyToMany pour attacher des/un nouveaux/nouvel auteur(s)
        // à un livre que l'on vient de créer en base de données.
        // Attention $request->authors correspond aux donnes du formulaire alors $book->authors() à la relation ManyToMany
        $book->authors()->attach($request->authors);

        // image
        $im = $request->file('picture');
        
        // si on associe une image à un book 
        if (!empty($im)) {
            
            $link = $request->file('picture')->store('./');

            // mettre à jour la table picture pour le lien vers l'image dans la base de données
            $book->picture()->create([
                'link' => $link,
                'title' => $request->title_image?? $request->title
            ]);
        }

        return redirect()->route('book.index')->with('message', 'success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);

        return view('back.book.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.edit', compact('book', 'authors', 'genres'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors.*' => 'integer', // pour vérifier un tableau d'entiers il faut mettre authors.*
            'status' => 'in:published,unpublished'
        ]);

        $book = Book::find($id); // associé les fillables

        $book->update($request->all());
        
        // on utilisera la méthode sync pour mettre à jour les auteurs dans la table de liaison
        $book->authors()->sync($request->authors);
        
        // image
        $im = $request->file('picture');
        
        // si on associe une image à un book 
        if (!empty($im)) {

            $link = $request->file('picture')->store('./');

            // suppression de l'image si elle existe 
            if(count($book->picture)>0){
                Storage::disk('local')->delete($book->picture->link); // supprimer physiquement l'image
                $book->picture()->delete(); // supprimer l'information en base de données
            }

            // mettre à jour la table picture pour le lien vers l'image dans la base de données
            $book->picture()->create([
                'link' => $link,
                'title' => $request->title_image?? $request->title
            ]);
            
        }

        return redirect()->route('book.index')->with('message', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        $book->delete();

        return redirect()->route('book.index')->with('message', 'success delete');
    }
}
