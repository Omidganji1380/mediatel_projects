<?php

namespace App\Http\Livewire\Front\Blog;

use App\Http\Livewire\Front\Blog\Favorite;
use App\Models\Blog\Post;
use Livewire\Component;

class Card extends Component
{
    use Favorite;

    public Post $post;

    public function render()
    {
        return view('livewire.front.blog.card');
    }
}
