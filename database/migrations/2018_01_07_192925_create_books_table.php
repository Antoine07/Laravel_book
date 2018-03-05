<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id'); // clé primaire
            $table->unsignedInteger('genre_id')->nullable(); // UNSIGNED INTEGER un livre peut ne pas avoir de genre
            $table->string('title', 100); // VARCHAR 100
            $table->text('description')->nullable(); // TEXT NULL
            $table->dateTime('published_at')->nullable();
            $table->enum('status', ['published', 'unpublished'])->default('unpublished');
            // on ajoute une contrainte sur la suppression ainsi si on supprime un genre alors on met NULL à la place de l'id
            // du genre associé au livre(s), ce qui permet de supprimer un genre sans supprimer les livres qui sont associés
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('SET NULL'); // Contrainte référencé sur la table genres.id
            $table->timestamps(); // timestamps 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
