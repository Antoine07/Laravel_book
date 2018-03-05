<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function books(){
        return $this->belongsToMany(Book::class);
    }
}


