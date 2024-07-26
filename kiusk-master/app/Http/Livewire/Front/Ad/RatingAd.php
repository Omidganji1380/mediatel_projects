<?php

namespace App\Http\Livewire\Front\Ad;

use App\Events\RatingEvent;
use App\Models\Ad\Ad;
use App\Models\Blog\Post;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Spatie\ResponseCache\Facades\ResponseCache;

trait RatingAd
{
    public $ratingable;

    public function mountRating($initialRating = 0)
    {
        if (Auth::check()) {
            // User is logged in, retrieve their previous rating
            $this->rating = $this->getUserRating();
        } else {
            $this->rating = $initialRating;
        }
    }

    public function rate($rating)
    {
        if (Auth::check()) {
            // User is logged in, save their rating
            $this->saveUserRating($rating);
        } else {
            // User is not logged in, redirect to login page
            return redirect()->route('login');
        }

        $this->rating = $rating;
    }

    private function getUserRating()
    {
        $userId = Auth::id();

        // Retrieve the user's previous rating using Eloquent relationships
        $rating = Rating::where('user_id', $userId)
            ->where('ratingable_type', $this->ratingableType())
            ->where('ratingable_id', $this->ratingableId())
            ->first();

        return $rating ? $rating->rate : 0; // Default rating if no previous rating found
    }

    private function saveUserRating($rating)
    {
        $userId = Auth::id();

        $this->scoreRate();

        // Save the user's rating using Eloquent relationships
        $rating = Rating::updateOrCreate(
            [
                'user_id' => $userId,
                'ratingable_type' => $this->ratingableType(),
                'ratingable_id' => $this->ratingableId(),
            ],
            ['rate' => $rating]
        );

        $this->swal('success', __('Rate submitted successfully'));
    }

    private function ratingableType()
    {
        // Determine the type of the ratingable model (Ad or Post) based on your logic
        // Here, we assume you have a property named 'ratingable' that holds the instance of the ratingable model
        if ($this->ratingable instanceof Ad) {
            return Ad::class;
        } elseif ($this->ratingable instanceof Post) {
            return Post::class;
        }

        return null; // Return null or handle the case when the ratingable type is not recognized
    }

    private function ratingableId()
    {
        // Retrieve the ID of the ratingable model
        // Here, we assume you have a property named 'ratingable' that holds the instance of the ratingable model
        return $this->ratingable->id;
    }

    public function highlightStar($star)
    {
        if ($this->isHovering()) {
            $this->rating = $star;
        }
    }

    public function resetStars()
    {
        if ($this->isHovering()) {
            $this->rating = $this->getUserRating();
        }
    }

    private function isHovering()
    {
        return $this->rating !== $this->getUserRating();
    }

    public function scoreRate()
    {
        $rating = Rating::where('ratingable_type' , $this->ratingableType())
            ->where('ratingable_id' , $this->ratingableId())
            ->where('user_id', auth()->id())->exists();

        if(!$rating){
            RatingEvent::dispatch(auth()->user());
        }
    }
}
