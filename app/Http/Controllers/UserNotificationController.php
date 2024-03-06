<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
// user notification Page
public function notiPage(){
        $user = Auth::user();
        $type = 'App\Notifications\CommentNotification';
        $notification = $user->notifications()
                             ->where('type',$type)
                             ->orderBy('created_at','DESC')->paginate(5);

        // dd($orderNoti->toArray());
        return view('user.notification.notificationPage',compact('notification'));
}
// user notification detail
public function detail(Request $request){
        // logger($request->all());
        $user = Auth::user();
        $notification = $user->notifications()->where('id',$request->id)->first();
        // logger($notification);
        $productId = $notification['data']['product_id'];
        $commentId = $notification['data']['comment_id'];

        $question = Comment::where('id',$commentId)->first()->comment;
        $productImage = Product::where('id',$productId)->first()->first_image;
        return response()->json([
            'notiDetail' => $notification,
            'productImage' => $productImage,
            'question' => $question
        ]);
}
// user notification read
public function read(Request $request){
        $user = Auth::user();
        $notification = $user->notifications()->where('id',$request->id)->first()->markAsRead();

}
// user solo read delete
public function soloDelete($id){
        $user = Auth::user();
        $user->notifications()->whereNotNull('read_at')->where('id',$id)->delete();
        return back()->with(['message'=> 'Will read message  delete']);
}
// user order noti page
public function orderNotiPage(){
        $user = Auth::user();
        $type = 'App\Notifications\OrderNotification';
        $notification = $user->notifications()->where('type',$type)->orderBy('created_at','DESC')->paginate(5);
        // dd($notification->toArray());
        return view('user.notification.orderNotiPage',compact('notification'));
}
// order noti detail
public function orderNotiDetail(Request $request){
        // logger($request->all());

        $admin = User::where('id',$request->adminId)->first();
        $email = $admin->email;
        $pfImage = $admin->avatar;

        $noti =Auth::user()->notifications()->where('id',$request->id)->first();

        return response()->json([
            'message' => $noti,
            'image' => $pfImage,
            'email' => $email
        ]);

}

}
