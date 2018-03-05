<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $fillable = [
        'title', 'description', 'genre_id', 'status'
    ];

    // ici le setter va récupérer la valeur à insérer en base de données
    // nous pourrons alors vérifier sa valeur avant que le modèle n'insère la donnée en base de données
    public function setGenreIdAttribute($value){

        if($value == 0){
            $this->attributes['genre_id'] = null;
        }else{

            $this->attributes['genre_id'] = $value;
        }

    }

    public function scopePublished($query){
        return $query->where('status', 'published');
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function authors(){
        return $this->belongsToMany(Author::class);
    }

    public function picture(){
        return $this->hasOne(Picture::class);
    }

    public function scores(){
        return $this->hasMany(Score::class);
    }

    public function scopeBest($query){
        return $query
            ->join('scores', 'books.id', '=', 'scores.book_id')
            ->groupBy('book_id')
            ->selectRaw('scores.book_id, books.*, AVG(vote) as vote')
            ->orderBy('vote', 'DESC');
    }
}
