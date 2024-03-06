<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Heart;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\PreCard;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SingleProductController extends Controller
{
//singlePage
public function singlePage($id){

        $rating = Rating::select('ratings.*','users.name')
                        ->leftJoin('users','ratings.user_name','users.id')
                        ->where('ratings.product_id',$id)
                        ->orderBy('id','DESC')->paginate(3);
        // To increase view count
        $product = Product::where('id',$id)->select('views')->first();
        Product::where('id',$id)->update([
            'views' => $product->views + 1
        ]);
        $product = Product::select('products.*','product_images.images','sub_categories.subcategory')
                      ->leftJoin('sub_categories','products.category','sub_categories.id')
                      ->leftJoin('product_images','products.image','product_images.product_code')
                      ->where('products.id',$id)->get();


        $comment = Comment::select('comments.*','users.email')
                      ->leftJoin('users','users.id','comments.user_id')
                      ->where('product_id',$id)
                      ->orderBy('id','DESC')
                      ->get();

        if(Auth::user()){
            $userId = Auth::user()->id;
            $heart = Heart::where('user_id',$userId)->where('product_id',$id)->first();
        }else{
            $heart = 'unlogin';
        }



        //  dd($product->toArray());
       return view('singleProduct.singleProduct',compact('product','rating','comment','heart'));
}
// Add to Heart
public function heart(Request $request){
        Heart::create([
            'user_id' => $request->userId,
            'product_id' => $request->productId
        ]);
        return response()->json([
            'status' => 'success'
        ]);
}
// Show heart lists
public function heartLists(){
        $heart = Heart::select('hearts.*','products.name','products.brand','products.price','products.discount_price','products.first_image')
                        ->leftJoin('products','hearts.product_id','products.id')
                        ->where('hearts.user_id',Auth::user()->id)
                        ->orderBy('created_at','DESC')
                        ->paginate(5);
        // dd($heart->toArray());
        return view('user.heartlist.heartListShow',compact('heart'));
}
// Delet heart
public function heartDelete($id){
        Heart::where('id',$id)->delete();
        return back()->with(['message'=> 'whishlist is deleted']);
}
// Add to pre Cart
public function addtoCart(Request $request){
        // dd($request->all());
        if($request['shoe-size']){
            Validator::make($request->all(),[
                'shoe-size' => 'numeric'
            ])->validate();
        }

        $data =[
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'qty' => $request->qty,
        ];

        if($request['shirt-size']){
            $data['size'] = $request['shirt-size'];
        }elseif($request['shoe-size']){
            $data['size'] = $request['shoe-size'];
        }

        PreCard::create($data);
        return back()->with(['message' => 'Successful add to card']);
}
// Show to Card lists
public function cardListShow(){
       $card = PreCard::select('pre_cards.*','products.name','products.price','products.discount_price','products.first_image','products.discount_precentage')
               ->leftJoin('products','pre_cards.product_id','products.id')
               ->get();
        $totalPrice = 0;
        $totalQty = 0 ;
        foreach($card as $c){
           if($c->discount_price == null){
            $totalPrice += ($c->price * $c->qty);
           }else{
            $totalPrice += ($c->discount_price * $c->qty);
           }
          $totalQty += $c->qty;
        }
        // dd($totalPrice);
        return view('user.Card.cardList',compact('card','totalPrice','totalQty'));
}
// Solo delete card
public function cartSoloDelete($id){
       PreCard::where('id',$id)->delete();
       return redirect()->route('user#cardListShow')->with(['message' => 'Card delete successful']);
}
// All delete card
public function cartAllDelete(){
        PreCard::where('user_id',Auth::user()->id)->delete();
        return redirect()->route('user#cardListShow')->with(['message' => 'All Cards delete successful']);
}
// Add to Original Card
public function addCart(Request $request){
        foreach($request->all() as  $item){
            Cart::create($item);
        }
        PreCard::where('user_id',Auth::user()->id)->delete();
        return response()->json();
}
// Add to Original Card form Buy button
public function buyaddCart(Request $request){
        logger($request->all());
        $data = [
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->qty,
            'total' => $request->total,
            'order_code'=> $request->random
        ];
        if($request->shoe == Null && $request->shirt == Null){
            $data['size'] = NUll;
        }
        if($request->shoe !== Null){
            $data['size'] = $request->shoe;
        }
        if($request->shirt !== Null){
            $data['size'] = $request->shirt;
        }
        Cart::create($data);
        return response()->json(['code' => $request->random]);
}

}
