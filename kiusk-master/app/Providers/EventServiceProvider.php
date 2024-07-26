<?php

namespace App\Providers;

use App\Events\FreeSubscriptionEvent;
use App\Events\PinAdEvent;
use App\Events\ProfileEvent;
use App\Events\RatingEvent;
use App\Events\ReferralScoreEvent;
use App\Events\RegisterEvent;
use App\Events\ScoreEvent;
use App\Listeners\AssignRoleListener;
use App\Listeners\CreateReferralListener;
use App\Listeners\GrantProfileCompletionScoreListener;
use App\Listeners\GrantScoreListener;
use App\Listeners\PinAdEmailAdminListener;
use App\Listeners\PinAdListener;
use App\Listeners\ProfileCompletionListener;
use App\Listeners\RatingScoreListener;
use App\Listeners\ReferralScoreListener;
use App\Listeners\SubscribePlanListener;
use App\Listeners\WelcomeEmailListener;
use App\Models\Ad\Review;
use App\Models\Blog\Comment;
use App\Models\GoogleReview;
use App\Models\ServiceUsage;
use App\Models\UserVideo;
use App\Observers\CommentObserver;
use App\Observers\GoogleReviewObserver;
use App\Observers\ReviewObserver;
use App\Observers\ServiceUsageObserver;
use App\Observers\UserVideoObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RegisterEvent::class => [
            SubscribePlanListener::class,
            AssignRoleListener::class,
            CreateReferralListener::class,
            WelcomeEmailListener::class,
        ],
        ReferralScoreEvent::class => [
            ReferralScoreListener::class
        ],
        ProfileEvent::class => [
            ProfileCompletionListener::class,
            GrantProfileCompletionScoreListener::class
        ],
        RatingEvent::class => [
            RatingScoreListener::class,
        ],
        PinAdEvent::class => [
            PinAdListener::class,
            PinAdEmailAdminListener::class
        ],
        FreeSubscriptionEvent::class => [
            SubscribePlanListener::class,
        ],
        ScoreEvent::class => [
            GrantScoreListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Review::observe(ReviewObserver::class);
        Comment::observe(CommentObserver::class);
        GoogleReview::observe(GoogleReviewObserver::class);
        UserVideo::observe(UserVideoObserver::class);
        ServiceUsage::observe(ServiceUsageObserver::class);
    }
}
