<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlashSaleController extends Controller
{
//Flash Sale Page
public function FlashSalePage(){
        $disproduct = Product::select('products.*','sub_categories.subcategory','promotions.expired_date')
                            ->leftJoin('sub_categories','products.category','sub_categories.id')
                            ->leftJoin('promotions','promotions.product_id','products.id')
                            ->whereNotNUll('products.discount_price')->get();
        $date = Promotion::select('expired_date')->first();
        // dd($date->toArray());
        return view('admin.product.flashSale',compact('disproduct','date'));
}
//  Flash Sale Save
public function flshSaleSave(Request $request){
        // dd($request->all());
        Validator::make($request->all(),[
            'ids' => 'required',
            'date' => 'required'
        ],[
            'ids.required' => 'please choose products'
        ])->validate();
       foreach ($request->ids as $id) {
            Promotion::create([
                'product_id' => $id,
                'expired_date' => $request->date
            ]);
       }
       return back();
}
// Flash Sale delete
public function flashSaleDelete(Request $request){
        $undiscount = Promotion::select('product_id')->get();
        $undiscount->transform(function ($item, $key) {
            Product::where('id',$item->product_id)->update([
                'discount_price' => null
            ]);
        });
        Promotion::truncate();
        return response()->json();
}
}
