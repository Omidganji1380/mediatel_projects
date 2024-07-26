<?php

namespace App\Http\Livewire\Front\Ad\Show;

use App\Models\LinkClick;

trait ClickCount
{
    public $count;

    public function trackLinkClick($url)
    {
        // Check if a LinkClick record exists for the $ad
        $linkClick = $this->ad->linkClick;

        if ($linkClick) {
            // If a LinkClick record exists, increment the click_count
            $linkClick->increment('click_count');
        } else {
            // If no LinkClick record exists, create a new one with click_count set to 1
            $this->ad->linkClick()->create([
                'ad_id' => $this->ad->id,
                'click_count' => 1,
                'url' => $url
            ]);
        }

        // Redirect the user to the external URL
        return redirect($url);
    }
}
