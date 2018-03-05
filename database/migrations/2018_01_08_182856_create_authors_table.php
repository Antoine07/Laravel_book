<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->increments('id'); // PK automatique
            $table->string('name', 100); // obligatoire
            $table->string('email')->unique(); // un email est unique 
            $table->text('address')->nullable(); // adresse peut être facultative type NULL par défaut
            $table->string('phone', 100)->nullable(); // phone non obligatoire type NULL par défaut
            $table->timestamps(); // données pour Laravel 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
