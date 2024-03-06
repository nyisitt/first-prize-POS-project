<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ReviewNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
//home page ----------------------
public function home(){
        $subcategory = Product::select('products.first_image','sub_categories.subcategory')
                           ->leftJoin('sub_categories','products.category','sub_categories.id')
                           ->get();

        $popular = Product::orderBy('views','DESC')->take(12)->inRandomOrder()->get();
        $product = Product::select('products.*','ratings.user_name',DB::raw('count(products.id) as total'))
                            ->leftJoin('ratings','ratings.product_id','products.id')
                            ->groupBy('products.id')
                            ->inRandomOrder()->paginate(12);
        $promotion = Promotion::select('promotions.*','products.*')
                            ->leftJoin('products','promotions.product_id','products.id')
                            ->get();
                        //  dd($promotion->toArray());

        return view('welcome',compact('product','subcategory','popular','promotion'));
}

// profile show ---------------------
public function pfshow(){
        return view('user.Profile.show');
}
// profile edit -----------------
public function pfedit(){
        return view('user.Profile.edit');
}
// profile update ----------------------
public function pfupdate(Request $request){
        $this->pfvalidate($request);
        $data = $this->putData($request);
        if($request->hasFile('image')){
            // Image Delete
           $oldName = User::where('id',$request->id)->select('image')->first();
           $oldName = $oldName['image'];
           Storage::delete(['public/'.$oldName ]);

        //    Image Store
        $newName = uniqid()."_".$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public',$newName);
        $data['image'] = $newName;
        }

        User::where('id',$request->id)->update($data);
        return redirect()->route('user#profileShow');
}

//email  edit -------------------------
public function emedit(){
        $category =SubCategory::get()->groupBy('category');
        return view('user.Profile.emailandphone.emailedit',compact('category'));
    }
    public function checkpassword(Request $request){
        $oldPassword = User::where('id',$request->id)->select('password')->first();
        $oldPassword = $oldPassword->password;
        if($oldPassword == null){
            return back()->with(['error' => 'Google or Facebook Login do not change email']);
        }
        if(Hash::check($request->password, $oldPassword)){
            return back()->with(['correct'=>'correct']);
        }
        return back()->with(['error' => 'The old Password do not match.Try Again']);
    }

    public function emupdate(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email,'.$request->id,

        ]);

        if ($validator->fails()) {
            return redirect()->route('user#emailEdit')->withErrors($validator)->with(['correct'=>'correct']);
        }
            User::where('id',$request->id)->update([
                'email' => $request->email,
            ]);
            return redirect()->route('user#profileShow');
}

//password Change ----------------
public function pschange(){
        return view('user.Profile.psChange');
}
//   password Update -----------------------
public function psupdate(Request $request){
        $this->password($request);
        $oldPassword = User::where('id',$request->id)->select('password')->first();
        $oldPassword = $oldPassword->password;
        if($oldPassword == null){
            return back()->with(['error' => 'Google or Facebook Login do not change password']);
        }
        if(Hash::check($request->oldPassword, $oldPassword)){
            User::where('id',$request->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            return back()->with(['message'=> 'Password Change is successful.You can check logout.Thank You !']);
        }
        return back()->with(['error' => 'The Old Password do not match']);
}

//  ********************  private function ******************
   private function pfvalidate($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'image' => 'image',
            'gender' => 'required',
            'phone' => 'required|min:9|unique:users,phone,'.$request->id
        ])->validate();
   }
   private function password($request){
    Validator::make($request->all(),[
        'oldPassword' => 'required|min:6',
        'newPassword' => 'required|min:6',
        'confirm' => "required|same:newPassword"
    ])->validate();
   }
   private function putData($request){
    return[
        'name' => $request->name,
        'gender'=> $request->gender,
        'phone' => $request->phone
    ];
   }
}
