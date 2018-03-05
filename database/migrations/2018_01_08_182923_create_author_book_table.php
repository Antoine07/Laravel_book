<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_book', function (Blueprint $table) {
            $table->unsignedInteger('author_id'); // le type doit correspondre au type de la clé primaire de la table authors
            $table->unsignedInteger('book_id');
            // On met une cascade si on supprime un auteurs on supprime les informations dans la table de liaison 
            // En effet ces informations sont inutiles ils ne servent qu'à relier les deux tables si un auteur disparaît de 
            // la base de données l'information dans la table de liaison n'a plus de sens.
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('author_book');
    }
}
