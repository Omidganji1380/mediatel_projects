<?php

namespace Database\Seeders;

use App\Models\Blog\Post;
use Illuminate\Database\Seeder;

class BlogUrlSeeder extends Seeder
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
            $post->update([
                'current_url' => route('front.blog.show', $post->slug),
                'old_url' => $post->old_slug ? $post->old_link : null,
            ]);
        }
    }
}
