<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BooksTableSeeder extends Seeder
{
    private $faker;

    // injection du service Faker dans la classe BookTableSeeder
    public function __construct(Faker $faker){
        $this->faker = $faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // on prendra garde de bien supprimer toutes les images avant de commencer les seeders
        Storage::disk('local')->delete(Storage::allFiles());

        // création des genres
        App\Genre::insert([
            [ 'name' => 'science' ],
            [ 'name' => 'maths' ],
            [ 'name' => 'cookbooks' ],
        ]);

        // création de 30 livres à partir de la factory
        factory(App\Book::class, 30)->create()->each(function($book){

            // associons un genre à un livre que nous venons de créer
            $genre = App\Genre::find(rand(1,3));

            // pour chaque $book on lui associe un genre en particulier
            $book->genre()->associate($genre);

            $book->save(); // il faut sauvegarder l'association pour faire persister en base de données

            // ajout des images
            // On utilise futurama sur lorempicsum pour récupérer des images aléatoirement
            // attention il n'y en a que 9 en tout différentes

            $link = str_random(12) . '.jpg';
            $file = file_get_contents('http://lorempicsum.com/futurama/250/250/' . rand(1, 9)); // flux
            Storage::put($link, $file);


            $book->picture()->create([
                'title' => 'Default', // valeur par défaut
                'link' => $link
            ]);

            // récupération des id des auteurs à partir de la méthode pluck d'Eloquent
            // les méthodes du pluck shuffle et slice permettent de mélanger et récupérer un certain
            // nombre 3 à partir de l'indice 0, comme ils sont mélangés à chaque fois qu'un livre est créé
            // on aura des id à chaque fois aléatoires.
            // La méthode all permet de faire la requête et de récupérer le résultat sous forme d'un tableau
            $authors =App\Author::pluck('id')->shuffle()->slice(0,rand(1,3))->all();

            // Il faut se mettre maintenant en relation avec les auteurs (relation ManyToMany) et attacher les id des auteurs
            // dans la table de liaison.

            $book->authors()->attach($authors);

            // création de score en utilisant Faker directement dans BookTableSeeder
            $scores = [];
            foreach(range(0, rand(0,10)) as $range){
                $scores[]= ['ip' => $this->faker->ipv4, 'vote' => rand(0,5)];
            }
            // la méthode createMany permet de créer plusieurs enregistrement en même temps dans la relation scores
            if(!empty($scores))
                $book->scores()->createMany($scores);
        });

        
    }
}

