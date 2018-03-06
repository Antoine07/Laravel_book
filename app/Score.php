<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['ip', 'book_id', 'vote'];

    public function book(){
        return $this->belongsTo(Book::class);
    }
}


