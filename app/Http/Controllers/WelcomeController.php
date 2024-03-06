<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
//product lists ------------------------
public function productlists($name){


        $brand = Product::select('products.brand')
                        ->where('sub_categories.subcategory',$name)
                        ->leftJoin('sub_categories','products.category','sub_categories.id')
                        ->groupBy('products.brand')->get();
        $product = Product::select('products.*','sub_categories.subcategory','ratings.user_name',DB::raw('count(products.id) as total'))
                        ->where('sub_categories.subcategory',$name)
                        ->leftJoin('sub_categories','products.category','sub_categories.id')
                        ->leftJoin('ratings','ratings.product_id','products.id')
                        ->groupBy('products.id')
                        ->paginate(8);
                // dd($product->toArray());
        return view('welcomeProduct.products',compact('product','brand'));
    }
    public function paginateProduct(Request $request){
        if($request->ajax()){
            $product = Product::select('products.*','sub_categories.subcategory','ratings.user_name',DB::raw('count(products.id) as total'))
                        ->where('sub_categories.subcategory',$request->category)
                        ->leftJoin('sub_categories','products.category','sub_categories.id')
                        ->leftJoin('ratings','ratings.product_id','products.id')
                        ->groupBy('products.id')
                        ->paginate(8);
        }
        return view('welcomeProduct.child_product',compact('product'))->render();
}
// SearchBar ---------------------------------
public function search(){
        if(request('key')){
            $product = Product::select('products.*','sub_categories.subcategory')
                            ->leftJoin('sub_categories','products.category','sub_categories.id')
                            ->where('products.name','like','%'.request('key').'%')
                            ->orWhere('sub_categories.subcategory','like','%'.request('key').'%')
                            ->first();
                            // dd($product->toArray());
        if($product != null){
            $subcategory = $product->subcategory;
        return redirect()->route('productList',$subcategory);
        }
        }
        return redirect()->route('welcome');

}
// sorting price -----------------------------
public function price(Request $request){

        $minvalue = $request->min;
        $maxvalue = $request->max;
        if($request->value == 'hight'){
            $productQuery = Product::select('products.*','sub_categories.subcategory','ratings.user_name',DB::raw('count(products.id) as total'))
                        ->where('sub_categories.subcategory',$request->category)
                        ->leftJoin('sub_categories','products.category','sub_categories.id')
                        ->leftJoin('ratings','ratings.product_id','products.id')
                        ->groupBy('products.id')
                        ->orderByRaw("CAST(IFNULL(discount_price, price) AS UNSIGNED) DESC, IFNULL(discount_price, price) DESC");

         if ($request->has('brand')) {
                            $productQuery->where('products.brand', $request->brand);
          }
          $product = $productQuery->get();
                        return response()->json($product);
        }

        if($request->value == 'low'){
            $productBrand = Product::select('products.*','sub_categories.subcategory','ratings.user_name',DB::raw('count(products.id) as total'))
                        ->where('sub_categories.subcategory',$request->category)
                        ->leftJoin('sub_categories','products.category','sub_categories.id')
                        ->leftJoin('ratings','ratings.product_id','products.id')
                        ->groupBy('products.id')
                        ->orderByRaw("CAST(IFNULL(discount_price, price) AS UNSIGNED) ASC, IFNULL(discount_price, price) ASC");
           if ($request->has('brand')) {
                            $productBrand->where('products.brand', $request->brand);
             }

          $product = $productBrand->get();
                        return response()->json($product);
        }
}

// sorting brand -----------------------------
public function brand(Request $request){
        $product = Product::select('products.*','sub_categories.subcategory','ratings.user_name',DB::raw('count(products.id) as total'))
                            ->where('sub_categories.subcategory',$request->category)
                            ->where('products.brand',$request->brand)
                            ->leftJoin('sub_categories','products.category','sub_categories.id')
                            ->leftJoin('ratings','ratings.product_id','products.id')
                            ->groupBy('products.id')
                            ->get();

        return response()->json($product);
}
// sorting min max price ---------------------------
public function betweenPrice(Request $request){

        $minvalue = $request->min;
        $maxvalue = $request->max;
        $product= Product::select('products.*', 'sub_categories.subcategory','ratings.user_name',DB::raw('count(products.id) as total'))
                            ->where('sub_categories.subcategory', $request->category)
                            ->leftJoin('sub_categories', 'products.category', 'sub_categories.id')
                            ->leftJoin('ratings','ratings.product_id','products.id')
                            ->groupBy('products.id')
                            ->where(function ($query) use ($minvalue, $maxvalue) {
                        $query->where(function ($q) use ($minvalue, $maxvalue) {
                // Check discount price is null
                            $q->whereNull('discount_price')
                              ->where('price', '>=', $minvalue)
                              ->where('price', '<=', $maxvalue);
                            })->orWhere(function ($q) use ($minvalue, $maxvalue) {
                // Check discount price is not null
                            $q->whereNotNull('discount_price')
                              ->where('discount_price', '>=', $minvalue)
                              ->where('discount_price', '<=', $maxvalue);
                        });
                    })->get();


                    return response()->json($product);

}

//   sorting review hight  -----------------------
public function reviewhight(Request $request){
            $product = Product::select('products.*','sub_categories.subcategory','ratings.user_name',DB::raw('count(products.id) as total'))
                            ->where('sub_categories.subcategory',$request->category)
                            ->leftJoin('sub_categories','products.category','sub_categories.id')
                            ->leftJoin('ratings','ratings.product_id','products.id')
                            ->groupBy('products.id')
                            ->orderBY('total','DESC')
                            ->get();
                 return response()->json($product);
        }
        public function reviewlow(Request $request){

            $product = Product::select('products.*','sub_categories.subcategory','ratings.user_name',DB::raw('count(products.id) as total'))
                            ->where('sub_categories.subcategory',$request->category)
                            ->leftJoin('sub_categories','products.category','sub_categories.id')
                            ->leftJoin('ratings','ratings.product_id','products.id')
                            ->groupBy('products.id')
                            ->orderByRaw('ISNULL(user_name) DESC , total asc')
                            ->get();

                 return response()->json($product);
}

}
