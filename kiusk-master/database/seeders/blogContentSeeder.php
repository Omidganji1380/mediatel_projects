<?php

namespace Database\Seeders;

use App\Models\Blog\Post;
use Illuminate\Database\Seeder;

class blogContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();

        foreach($posts as $post){
            $post->update(['content' => str_replace("https://kiusk.moneymakerapp.xyz", env('APP_URL'), $post->content)]);
        }
    }
}
