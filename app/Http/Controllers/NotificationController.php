<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{

// admin rating notification page
public function adminNotiShow(){
        $user = Auth::user();
        $type = 'App\Notifications\ReviewNotification';
        $notification = $user->notifications()->where('type',$type)->orderBy('created_at','DESC')->paginate(5);
        // dd($notification->toArray());
        return view('admin.notification.notificationPage',compact('notification',));
}
// admin rating notification detail
public function adminNotiDetail(Request $request){

        $user = Auth::user();
        $notidetail = $user->notifications()->where('id',$request->id)->first();

        return response()->json($notidetail);
}
// admin rating noti read
public function adminNotiRead(Request $request){
        $user = Auth::user();
        $notidetail = $user->notifications()->where('id',$request->id)->first();
        $notidetail->markAsRead();
        return response()->json();
}
// admin rating noti read delete
public function adminNotiDelete(){
        $user = Auth::user();
        $type = 'App\Notifications\ReviewNotification';
        $user->notifications()->whereNotNull('read_at')->where('type',$type)->delete();
        return redirect()->route('admin#notiShow')->with(['message' => 'All read message delete success']);
}
// admin rating solo delete
public function adminRatingReadDelete($id){
        $user = Auth::user();
        $user->notifications()->whereNotNull('read_at')->where('id',$id)->delete();
        return back()->with(['message'=> 'Will read message  delete']);
}

// admin comment noti show
public function adminquestionShow(){
        $user = Auth::user();
        $type = "App\Notifications\CommentNotification";
       $notification = $user->notifications()->where('type',$type)->orderBy('created_at','DESC')->paginate(5);

        return view('admin.notification.comment',compact('notification'));
}
// admin comment detail
public function adminquestDetail(Request $request){
        // logger($request->all());
        $user = Auth::user();
        $notidetail = $user->notifications()->where('id',$request->id)->first();
       $commentId = $notidetail['data']['comment_id'];
       $reply = Comment::where('id',$commentId)->select('reply')->first();
        if($reply){
            $reply = $reply->reply;
        }else{
            return response()->json(['message' => 'This comment is deleted']);
        }
        return response()->json([
            'notidetail' => $notidetail,
            'reply' => $reply
        ]);
}
// admin comment reply
public function adminReply(Request $request){

       Comment::where('id',$request->commentId)->update([
        'reply' => $request->reply,
        'status' => $request->status
       ]);
    //    Notification customer
        $customer = Comment::select('user_id','product_id')->where('id',$request->commentId)->first();
        $customer_id = $customer->user_id;
        $replyCustomer = User::where('id',$customer_id)->first();

        $product_id = $customer->product_id;
        $productName = Product::where('id',$product_id)->first()->name;

        $title = ' Reply for '. $productName;
        $message = $request->reply ;
        $productId = $product_id;
        $userId = 'Admin';
        $commentId = $request->commentId;

        Notification::send($replyCustomer, new CommentNotification($title, $message, $productId, $userId,$commentId));
    // notification end
       $user = Auth::user();
       $user->notifications()->where('id',$request->notiId)->first()->markAsRead();
       return response()->json([
        'message' => 'This product reply is successful'
       ]);
}
// admin read comment delete
public function questionDelete(){
        $user = Auth::user();
        $type = 'App\Notifications\CommentNotification';
        $user->notifications()->whereNotNull('read_at')->where('type',$type)->delete();
        return redirect()->route('admin#notiQuesShow')->with(['message' => 'All read message delete success']);
}
// admin solo read delete
public function notireadDelete($id){
        $user = Auth::user();
        $user->notifications()->whereNotNull('read_at')->where('id',$id)->delete();
        return back()->with(['message'=> 'Will read message  delete']);
}
// admin question lists
public function questionLists(){
        $commentlist = Comment::select('comments.*','users.name','products.name as product_name')
                            ->leftJoin('products','comments.product_id','products.id')
                            ->leftJoin('users','comments.user_id','users.id')
                            ->paginate(10);
                            // dd($comment->toArray());
        return view('admin.notification.questionLists',compact('commentlist'));
}
// admin question list delete
public function questionListDelete($id){
        Comment::where('id',$id)->delete();
        return back()->with(['message' => 'Comment delete successful']);
}
// admin question list edit
public function questionListEdit($id){
        $comment = Comment::where('id',$id)->first();
        return view('admin.notification.questionLIstEdit',compact('comment'));
}
// admin question list update
public function questionUpdate(Request $request){
        Validator::make($request->all(),[
            'reply' => 'required'
        ])->validate();
       Comment::where('id',$request->id)->update([
        'reply' => $request->reply
       ]);
        return redirect()->route('admin#questionLists')->with(['message' => 'comment update is successful']);
}
}
