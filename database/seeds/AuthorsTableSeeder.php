<?php

use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // création de 8 auteurs à partir de la factory
        factory(App\Author::class, 8)->create();
    }
}
