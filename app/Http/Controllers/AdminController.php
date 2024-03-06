<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
//home page
public function home(){
        $user = User::where('role','user')->get()->count();
        $delivery = User::where('role','deli')->get()->count();
        $admin = User::where('role','admin')->get()->count();
        $product = Product::get()->count();
        $order = Order::get()->count();
        $orderarrive = Order::where('status','3')->get()->count();
        $orderreject = Order::where('status','2')->get()->count();
        $totalprice = Order::sum('total_price');
        $totaldeli = Order::sum('deli_price');
        $cardprice = Payment::sum('amount');
        $homeprice = ($totalprice + $totaldeli) - $cardprice;

        // The most order list
        $customerCounts = Order::select('user_id','name','image','gender', DB::raw('count(user_id) as user_count'),DB::raw('sum(total_price) as totalPrice'))
                                    ->groupBy('user_id')
                                    ->leftJoin('users','orders.user_id','users.id')
                                    ->orderBy('user_count','DESC')
                                    ->get();
        // dd($customerCounts->toArray());
        return view('admin.home',compact('user','delivery','admin','product','order','orderarrive','orderreject','totalprice','totaldeli','cardprice','homeprice','customerCounts'));
}

// profile show
public function show(){
        return view('admin.profile.show');
}

// profile Edit
public function edit(){
      $profile =  User::where('id',Auth::user()->id)->first();
        return view('admin.profile.edit',compact('profile'));
}

// profile Update
public function update(Request $request){
        $this->profile($request);
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
        return back()->with(['message' => 'Profile Update is successful.Thank you !']);
}

// Password Edit
public function passwordEdit(){
        return view('admin.profile.password');
}

// Password Update
public function passwordUpdate(Request $request){
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

/************************************ private function*****************************/

// Validation
private function profile($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email'=> 'required|unique:users,email,'.$request->id,
            'gender'=> 'required',
            'image' => 'image',
            'phone' => 'required|min:9|unique:users,phone,'.$request->id,
            ])->validate();
}
private function password($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirm' => "required|same:newPassword"
        ])->validate();
}
    // Input Data
private function putData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender'=> $request->gender,
            'phone' => $request->phone,
        ];
}
}
