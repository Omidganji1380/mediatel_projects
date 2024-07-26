<?php

namespace App\Filament\Widgets;

use App\Models\Ad\Ad;
use App\Models\Ad\Review;
use App\Models\Blog\Comment;
use App\Models\Blog\Post;
use App\Models\Discount;
use App\Models\Score;
use App\Models\User;
use App\Models\UserVideo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;

class OnlineUser extends BaseWidget
{
    protected static string $view = 'filament.widgets.online-user';
    protected static ?int $sort = 0;

    // public int $count = 0;
    protected function getCards(): array
    {
        $newConut = User::where('last_online_at', '>=', now()->subSeconds(800))
            //                  ->where('id', '<>', auth()->id())
            ->orderBy('last_online_at')
            ->count();
        //  session()->put('newCount', $newConut0);
        ////  $make = Card::make('تعداد افراد آنلاین 5 ثانیه گذشته', number_format($newConut));
        ////  dump('ddddddddwwwww', $this->count, $newConut, 'ppppppp');
        ////  session()->c
        //  $c = session()->get('count');
        //  $newConut = session()->get('newCount');
        //  dump($c);
        //  if (isset($c) && $c) {
        ////   dump(0);
        //   if ($newConut > $c) {
        ////    dump(1);
        //    $percent = (($newConut - $c) / $c) * 100;
        //    $make = Card::make('تعداد افراد آنلاین 5 ثانیه گذشته', number_format($newConut))
        //                ->description("افزایش ${percent} درصد")
        //                ->descriptionColor('success')
        //                ->descriptionIcon('heroicon-s-trending-up');
        //   }
        //   if ($newConut < $c) {
        ////    dump(2);
        //    $percent = (($c - $newConut) / $c) * 100;
        //    $make = Card::make('تعداد افراد آنلاین 5 ثانیه گذشته', number_format($newConut))
        //                ->description("کاهش ${percent} درصد")
        //                ->descriptionColor('error')
        //                ->descriptionIcon('heroicon-s-trending-down');
        //   }
        //   if ($newConut === $c) {
        //    dump(2);
        $make = Card::make(
            'تعداد افراد آنلاین 60 ثانیه گذشته',
            number_format($newConut)
        ) //                ->description("بدون تغییر")
        ;
        //                ->descriptionColor('error')
        //                ->descriptionIcon('heroicon-s-trending-down');
        //   }
        //  }
        //  else {
        //   dump(3);
        //  }
        //  session()->put('count', $newConut);
        //  session()->put('count', $this->count);
        //  $this->count = $newConut;
        $countAds = number_format(Ad::whereIsVisible(true)
            ->count());
        $ads = Card::make('کل آگهی‌های منتشر شده', $countAds);
        $countAds2 = number_format(Ad::whereIsVisible(false)
            ->count());
        $ads2 = Card::make('کل آگهی‌های در انتظار تایید.', $countAds2);
        $reviews = Card::make('کل دیدگاه های تایید نشده آگهی ها', number_format(Review::whereIsVisible(false)
            ->count()));
        $allReviews = Card::make('کل دیدگاه های آگهی ها', number_format(Review::count()));
        $posts = Card::make('کل مقالات', number_format(Post::count()));
        $users = Card::make('کل کاربران', number_format(User::count()));
        $users2 = Card::make('کل کاربران تلگرام', number_format(User::whereNotNull('telegram_id')
            ->count()));
        $comments = Card::make('کل دیدگاه های وبلاگ تایید نشده', number_format(Comment::whereIsVisible(false)
            ->count()));
        $allComments = Card::make('کل دیدگاه های وبلاگ', number_format(Comment::count()));
        $claimedScores = Card::make('کل امتیازات کسب شده', number_format(Score::whereClaimed(true)
            ->count()));
        $confirmedDiscounts = Card::make('کل کدهای تخفیف ایجاد شده', number_format(Discount::count()));
        $uploadedVideos = Card::make('کل ویدیو های اپلود شده', number_format(UserVideo::count()));
        return [
            $make,
            $ads,
            $ads2,
            $reviews,
            // $allReviews,
            $posts,
            $comments,
            // $allComments,
            $users,
            $users2,
            $claimedScores,
            $confirmedDiscounts,
            $uploadedVideos,
        ];
    }
}
