<?php

namespace App\Http\Controllers;

use Cache;
use App\Book; // importez l'alias de la classe Book plus partique à utiliser dans le code 
use App\Genre;
use App\Author;
use App\Score;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $paginate = 5; // factorisation de la pagination 

    public function __construct(){

        // méthode pour injecter des données à une vue partielle 
        view()->composer('partials.menu', function($view){
            $genres = Genre::pluck('name', 'id')->all(); // on récupère un tableau associatif ['id' => 1]
            $view->with('genres', $genres ); // on passe les données à la vue
        });
    }

    public function index(){
        
        $prefix = request()->page?? '1';
        $key = 'book' . $prefix;

        $books = Cache::remember($key, 1 ,function(){
            return Book::published()->with('picture', 'authors')->paginate($this->paginate); // pagination
        });

        return view('front.index', ['books' => $books]);

    }

    public function show(int $id){
        // vous ne récupérez qu'un seul livre 
        $book = Book::find($id);

        $ips = $book->scores()->pluck('ip');
        $clientIp = request()->ip();

        $lock = $ips->search($clientIp)? true : false;

        // que vous passez à la vue
        return view('front.show', ['book' => $book, 'lock' => $lock]);
    }

    public function showBookByAuthor(int $id){

        $author= Author::find($id); // récupérez les informations liés à l'auteur
        $books = $author->books()->paginate($this->paginate); // on récupère tous les livres d'un auteur

        // On passe les livres et le nom de l'auteur
        return view('front.author', ['books' => $books, 'author' => $author]);

    }

    public function showBookByGenre(int $id){
        // on récupère le modèle genre.id 
        $genre = Genre::find($id);

        $books = $genre->books()->paginate($this->paginate);

        return view('front.genre', ['books' => $books, 'genre' => $genre]);
    }

    public function create(Request $request){
        
        $this->validate($request, [
            'ip' => 'ipv4',
            'book_id' => "integer|required|uniqueVoteIp:{$request->ip}",
            'vote' => 'integer',
        ]);

        $score = Score::create($request->all());

        return back()->with('message', 'Votre vote a bien été pris en compte, merci');
    }

}

