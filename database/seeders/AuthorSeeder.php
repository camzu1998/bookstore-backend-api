<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

use App\Models\Author;
use App\Models\Book;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::factory()->hasBooks(3, new Sequence(
            ['type' => 'both'],
            ['type' => 'pdf'],
        ))->count(3)->create();
    }
}