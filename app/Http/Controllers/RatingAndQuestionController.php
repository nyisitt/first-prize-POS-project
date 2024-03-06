<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReviewNotification;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\Notification;

class RatingAndQuestionController extends Controller
{
//input rating and review -----------------------
public function ratingInput(Request $request){
        // notification
        $product= Product::select('name')->where('id',$request->productId)->first();
        $productName = $product->name;
        $user = Auth::user();
        $userName = $user->name;
        $userEmail = $user->email;

        $title = 'Rating And Review';
        $message = $userName .' give '. $request->rating .' stars and  '. $request->review . ' review to ' . $productName;
        $sourceable_Id = $user->id ;
        $sourceable_type = User::class;


        $admins = Auth::user()->where('role','admin')->get();
        Notification::send($admins, new ReviewNotification($title, $message, $sourceable_Id, $sourceable_type));


        Rating::create([
            'user_name' => $request->userId,
            'product_id'=> $request->productId,
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return response()->json(['message' => 'Thanks You For Your Reviews And Rating']);
}

// rating pagination -------------------------
public function ratingPagination(Request $request){
        if($request->ajax()){
            $rating = Rating::select('ratings.*','users.name')
                            ->leftJoin('users','ratings.user_name','users.id')
                            ->where('ratings.product_id',$request->productId)
                            ->orderBy('id','DESC')->paginate(3);
          return view('singleProduct.pagination_rating',compact('rating'))->render();
        }
}
// check product -----------------------
public function checkProduct(Request $request){
        $check = Rating::where('user_name',$request->userId)->where('product_id',$request->productId)->get();

        if(count($check) == 0){
            return response()->json(['message' => 'true']);
        }else{
            return response()->json(['message' => 'false','outputdata'=> $check]);
        }
}

// get rating and review ----------------------
public function ratingGet(Request $request){
       $product_id = $request->product_id;
        $avage_rating = 0;
        $total_review = 0;
        $five_star = 0;
        $four_star =0;
        $three_star = 0;
        $two_star = 0 ;
        $one_star = 0;
        $total_user_rating = 0;


        $result = Rating::where('product_id',$product_id)->orderBy('id','DESC')->get();

            foreach($result as $item){

                if($item->rating == 5){
                    $five_star++ ;
                }
                if($item->rating == 4){
                    $four_star++ ;
                }
                if($item->rating == 3){
                    $three_star++ ;
                }
                if($item->rating == 2){
                    $two_star++ ;
                }
                if($item->rating == 1){
                    $one_star++ ;
                }
                $total_review++;
                $total_user_rating += $item->rating;

            }

            if($total_user_rating !==0){
                $avage_rating = $total_user_rating / $total_review;
            $avage_rating = number_format($avage_rating,1);
            }

            return response()->json([
            'avage_rating' => $avage_rating,
            'total_review' => $total_review,
            'five_star' => $five_star,
            'four_star' => $four_star,
            'three_star' => $three_star,
            'two_star' => $two_star,
            'one_star' => $one_star
        ]);


}

// rating and review show -------------------------
public function rating(){

        $userId = Auth::user()->id;
        $rating = Rating::select('ratings.*','products.first_image','products.name')
                        ->leftJoin('products','ratings.product_id','products.id')
                        ->where('ratings.user_name',$userId)
                        ->orderBy('products.id','DESC')->paginate(5);

        return view('user.Rating&Review.ratingshow',compact('rating'));
}

// rating delete ----------------------
public function ratingDelete($id){
        Rating::where('id',$id)->delete();
        return back()->with(['message' => 'Review delete successful']);
}

//********************************** */ Comment and Reply section *****************
// Comment to Admin
public function comment(Request $request){
        // logger($request->all());
        $comment = Comment::create([
            'user_id' => $request->userId,
            'product_id' =>$request->productId,
            'comment' => $request->comment
        ]);
        $commentId = $comment->id;
        // notification to Admin
        $product= Product::select('name','sub_categories.subcategory')
                        ->leftJoin('sub_categories','products.category','sub_categories.id')
                        ->where('products.id',$request->productId)->first();

        $productName = $product->name;
        $productCategory = $product->subcategory;
        $user = Auth::user();
        $userName = $user->name;
        $userEmail = $user->email;

        $title = "Comment for " . $productName  ;
        $message =  $request->comment .' mented to product '. $productName . ' category ' . '( ' .$productCategory .' ) ';
        $productId = $request->productId;
        $userId = $request->userId;
        $commentId = $commentId;

        $admins = Auth::user()->where('role','admin')->get();
        Notification::send($admins, new CommentNotification($title, $message, $productId, $userId,$commentId));


        return response()->json();

}
}
