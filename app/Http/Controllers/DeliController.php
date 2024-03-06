<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\DeliInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class DeliController extends Controller
{
//home page
public function home(){

        $userId = Auth::user()->id;
        $orderlist = DeliInfo::when(request('key'),function($q){
                    $q->where('orders.card_code','like','%'.request('key').'%');
                    })-> select('deli_infos.*','orders.card_code','orders.deli_code','orders.total_price','orders.deli_price','orders.payment')
                                ->where('deli_infos.deli_id',$userId)
                                ->leftJoin('orders','orders.id','deli_infos.order_id')
                                ->orderBy('deli_infos.created_at','DESC')
                                ->paginate(5);
        $orderlist->appends(request()->all());
                                // dd($orderlist->toArray());
        return view('delivery.ordershow',compact('orderlist'));
}
// profile Page
public function profilePage(){
        return view('delivery.profile.show');
}
// profile Edit
public function profileEdit(){
        return view('delivery.profile.edit');
}
// profile Update
public function profileUpdate(Request $request){
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
        return redirect()->route('deli#profilePage');
}
// email Edit
public function emailEdit(){
        return view('delivery.profile.emailEdit');
}
     // ps Check
public function psCheck(Request $request){
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
     // email Update
    public function emailUpdate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email,'.$request->id,

        ]);

        if ($validator->fails()) {
            return redirect()->route('deli#emailEdit')->withErrors($validator)->with(['correct'=>'correct']);
        }else{
            User::where('id',$request->id)->update([
                'email' => $request->email,
            ]);
            return redirect()->route('deli#profilePage');
        }

}
// password edit
public function psEdit(){
        return view('delivery.profile.password');
}
// password Update
public function psUpdate(Request $request){
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
// Choose Deli Page Admin Page
public function chooseDeliPage($id){
        // dd(request('key'));
        $delivery = User::where('role','deli')->get();
        $order = Order::where('id',$id)->first();
        $deliInfo = DeliInfo::when(request('key'),function($q){
                                $q->where('orders.card_code','like','%'.request('key').'%')
                                ->orwhere('users.name','like','%'.request('key').'%');
                                })->select('deli_infos.*','users.name','orders.card_code')
                                ->leftJoin('users','users.id','deli_infos.deli_id')
                                ->leftJoin('orders','orders.id','deli_infos.order_id')
                                ->orderBy('deli_infos.created_at','DESC')
                                ->paginate(5);
        $deliInfo->appends(request()->all());
        // dd($deliInfo->toArray());
        return view('admin.delivery',compact('delivery','order','deliInfo'));
}
// Send to delivery form Admin Page
public function deliSend(Request $request){
       DeliInfo::create([
            'deli_id' => $request->deliId,
            'order_id' => $request->orderId,
            'expired_date' => $request->date
       ]);
       Order::where('id',$request->orderId)->update([
        'status' => 3
       ]);

    //----------    notification for success
    $code = Order::where('id',$request->orderId)->select('card_code','user_id')->first();
    $customerId = $code->user_id;
    $customer = User::where('id',$customerId)->first();

    $order_code = $code->card_code;
    $deliId = $request->deliId;
    $deliName = User::where('id',$deliId)->first()->name;
    // logger($deliName);

    $title = 'Success for Order';
    $message = ' Order Code '. $order_code .' successed So we will sent by delivery '. $deliName .' Your order will arrive at '. $request->date .' You can contact delivery from our website messenger. Thank you ' ;
    $admin_id = $deliId;

    Notification::send($customer, new OrderNotification($title, $message, $admin_id));
    // ------------- noti end

       return response()->json();
}
// Deli Detail  form DeliPage
public function deliDetail($id){
        $order = Order::select('orders.*','deliveries.*','carts.product_id','carts.qty','carts.total','carts.size','products.name','products.first_image','products.price','products.discount_price')
                        ->leftJoin('deliveries','orders.deli_code','deliveries.deli_code')
                        ->leftJoin('carts','orders.card_code','carts.order_code')
                        ->leftJoin('products','products.id','carts.product_id')
                        ->where('orders.id',$id)->get();
        // dd($order->toArray());
        return view('delivery.orderdetail',compact('order'));
}
// Change State from DeliPage
public function deliStateChange(Request $request){
        DeliInfo::where('id',$request->orderId)->update([
            'status' => $request->state
        ]);
        return response()->json();
}
// Filter State from DeliPage
public function deliFilterState(Request $request){
        $userId = Auth::user()->id;
        // logger($request->all());

        if($request->state !== 'all'){
            $query =DeliInfo::select('deli_infos.*','orders.card_code','orders.deli_code','orders.total_price','orders.deli_price','orders.payment')
                         ->where('deli_infos.deli_id',$userId)
                        ->leftJoin('orders','orders.id','deli_infos.order_id')
                        ->orderBy('deli_infos.created_at','DESC')
                        ->where('deli_infos.status',$request->state)
                        ->where('deli_id',$userId)
                        ->get();
        }else{
            $query =DeliInfo::select('deli_infos.*','orders.card_code','orders.deli_code','orders.total_price','orders.deli_price','orders.payment')
                        ->where('deli_infos.deli_id',$userId)
                        ->leftJoin('orders','orders.id','deli_infos.order_id')
                        ->orderBy('deli_infos.created_at','DESC')
                        ->where('deli_id',$userId)
                        ->get();
                        }
       return response()->json($query);
}
//************************ */ private function ***************;
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
