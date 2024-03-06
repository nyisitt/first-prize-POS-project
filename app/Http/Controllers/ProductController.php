<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
//create page ---------------------------
public function create(){
        $category = SubCategory::get()->groupBy('category');
        // dd($category->toArray());
        return view('admin.product.create',compact('category'));
}
// create post -----------------------
public function createPost(Request $request){
        // dd($request->all());
        $this->product($request);
        $data = $this->databasePut($request);
        if($request->hasFile('images')){
            $images = $request->file('images');
            // Store first image
            $firstName = uniqid()."_".$images[0]->getClientOriginalName();
            $images[0]->storeAs('public',$firstName);
            $data['first_image'] = $firstName;

            // Store all image
            foreach ($images as $image){
                $imageName =uniqid()."_". $image->getClientOriginalName();
                $image->storeAs( 'public', $imageName);
                ProductImages::create([
                    'product_code' => $request->random,
                    'images' => $imageName
                ]);
            }
        }
        Product::create($data);
        return back()->with(['message'=> 'Product create is successful.Thank You!']);
}
// show ---------------------------------
public function show(){
        $products = Product::when(request('key'),function($q){
                    $q->orwhere('products.name','like','%'.request('key').'%')
                      ->orwhere('sub_categories.subcategory','like','%'.request('key').'%');
                    })
                    ->select('products.*','sub_categories.category as main_category','sub_categories.subcategory')
                    ->leftJoin('sub_categories','products.category','sub_categories.id')
                    ->orderBy('products.created_at','desc')
                    ->paginate(10);
        $products->appends(request()->all());
        $category = SubCategory::get()->groupBy('category');
        // dd($category->toArray());
        // dd($products->toArray());
        return view('admin.product.show',compact('products','category'));
}

// delete -------------------------------
public function delete($id){
        $productCode = Product::where('id',$id)->select('image','first_image')->first();
        $code = $productCode['image'];
        $firstImage = $productCode['first_image'];
        Storage::delete('public/'.$firstImage);
        $images = ProductImages::where('product_code',$code)->select('images')->get();
        foreach($images as $item){
            $imageName = $item['images'];
            Storage::delete('public/'.$imageName);
        }
        ProductImages::where('product_code',$code)->delete();
        Product::where('id',$id)->delete();
        return back()->with(['message' => 'Product delete is successful']);
    }
    public function imageDelete($id){
        // dd($id);
        Storage::delete('public/'.$id);
        ProductImages::where('images',$id)->delete();
        return back();
}

// detail -------------------------
public function detail($id){
        $product = Product::where('products.id',$id)
                            ->select('products.*','sub_categories.category as main_category','sub_categories.subcategory','product_images.images')
                            ->leftJoin('sub_categories','products.category','sub_categories.id')
                            ->leftJoin('product_images','products.image','product_images.product_code')
                            ->get();
        $category = SubCategory::get()->groupBy('category');
        $rating = Rating::where('product_id',$id)->get();
                            //  dd($rating->toArray());
        return view("admin.product.detail",compact('product','category','rating'));
}

// update product -----------------------
public function update(Request $request){
        $this->updateValidate($request);
        $data = [
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'brand' => $request->brand,
        ];

        if($request->hasFile('images')){
            $images = $request->file('images');
            // Store first image
            $firstName = uniqid()."_".$images[0]->getClientOriginalName();
            $images[0]->storeAs('public',$firstName);
            foreach ($images as $image){
                $imageName =uniqid()."_". $image->getClientOriginalName();
                $image->storeAs( 'public', $imageName);
                $productcode = Product::where('id',$request->id)->select('image')->first();
                $productcode = $productcode->image;
                $data['first_image'] = $firstName;
                ProductImages::create([
                    'product_code'=> $productcode,
                    'images' => $imageName
                ]);
            }
        }
        Product::where('id',$request->id)->update($data);
        return back()->with(['message' => 'Product Update is successful.']);
}

// discount section--------------------------
public function discount(Request $request){
        Validator::make($request->all(),[
            'percentage' => 'numeric'
        ])->validate();
        $percentage = $request->percentage;
        $query = Product::orWhere('category',$request->category);
        if($request->ids != null){
        $query->orWhereIn('id',$request->ids);
        }
        $products = $query->get();
        // to check products
        if($products){
            $products->map(function($p) use ($percentage){
                if($percentage!= null && $percentage >= 0){
                $discountAmount = $p->price * ($percentage / 100);
                $discountPrice = $p->price - $discountAmount;
                $discountPrice = ($discountPrice == $p->price) ? null : $discountPrice;
                $percentage = ($percentage == 0) ? null:$percentage;

                $p->update([
                    'discount_price' => $discountPrice,
                    'discount_precentage' => $percentage,
                ]);
                }
               });
        }
       return back();

}
// rating show ------------------------
public function ratingShow($rating){
        $decodedIds = explode(',', $rating);

        $ratingList = Rating::select('ratings.*','users.name','users.email')
                            ->leftJoin('users','ratings.user_name','users.id')
                            ->whereIn('ratings.id',$decodedIds )->get();
        // dd($ratingList->toArray());
        return view('admin.product.ratingList',compact('ratingList'));
}

//**************************************** */ private function*******************
private function product($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'images'=> 'required',
            "images.*"=> 'image|mimes:png,jpg,jpeg,webp',
            'description' => 'required'
        ])->validate();
}
private function updateValidate($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:png,jpg,jpeg,webp',
            'description' => 'required'
        ])->validate();
}
private function databasePut($request){
        return [
            'name' => $request->name,
            'description'=> $request->description,
            'price' => $request->price,
            'image' => $request->random,
            'category' => $request->category,
            'brand' => $request->brand
        ];
}
}
