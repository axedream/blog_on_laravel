<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;

class DatabaseSeeder extends Seeder
{
    use HasFactory;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BlogCategoriesTableSeeder::class);
        BlogPost::factory()->count(100)->create();
    }
}
