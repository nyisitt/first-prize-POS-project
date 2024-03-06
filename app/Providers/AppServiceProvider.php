<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\PreCard;
use App\Models\DeliInfo;
use App\Models\ChMessage;
use App\Models\SubCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrapFive();



            View::composer('*', function ( $view) {
                $category =SubCategory::get()->groupBy('category');
                $orderCount = Order::where('status','0')->get()->count();

                $user = Auth::user();
                $rating = 'App\Notifications\ReviewNotification';
                $comment = 'App\Notifications\CommentNotification';
                $order = 'App\Notifications\OrderNotification';
                    if($user){
                    $userId = Auth::user()->id;
                    $unread_noti = $user->unreadNotifications()->count();
                    $rating_unread = $user->unreadNotifications()->where('type',$rating)->count();
                    $comment_unread = $user->unreadNotifications()->where('type',$comment)->count();
                    $order_unread = $user->unreadNotifications()->where('type',$order)->count();

                    $card = PreCard::where('user_id',$userId)->count();
                    $message = ChMessage::where('seen','0')->where('to_id',$userId)->count();
                    $delinoti = DeliInfo::where('status','0')->where('deli_id',$userId)->count();
                        View::share([
                            'category' => $category,
                            'unread_noti' => $unread_noti,
                            'unread_rating' => $rating_unread,
                            'unread_comment' => $comment_unread,
                            'card_count' => $card,
                            'order_count'=> $orderCount,
                            'message_count' => $message,
                            'deli_count' => $delinoti,
                            'unread_order' =>$order_unread
                        ]);
                    }else{
                        View::share([
                            'category' => $category,
                        ]);
                    }





            });

}
}
