<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        // d'abord on crée les livres
        $this->call(AuthorsTableSeeder::class);
        // puis dans le code des seeders on les associera
        $this->call(BooksTableSeeder::class);
        
    }
}
