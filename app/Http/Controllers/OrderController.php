<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
//Delivery information page
public function deliveryPage(Request $request){
        // dd($request->toArray());
        $card = Cart::where('order_code',$request->data)->get();
        $qty = 0 ;
        foreach($card as $item){
            $qty += $item->qty;
        }

        $orderCode = $request->data;
        $totalPrice = $request->price;
        $deliveryPrice = $request->delivery;
        return view('user.Card.delivery',compact('orderCode','totalPrice','deliveryPrice','qty'));
}
// Delivery information Page from Buy
public function deliveryBuyPage(Request $request){
        logger($request->all());
        $card = Cart::where('order_code',$request->data)->first();
        $qty = $card->qty;
        $totalPrice = $card->total;
        $orderCode = $request->data;
        $deliveryPrice = 3000 ;
       return view('user.Card.delivery',compact('orderCode','totalPrice','qty','deliveryPrice'));

}
// Add to Delivery
public function addDelivery(Request $request){
        // logger($request->all());
        Delivery::create([
            'full_name' => $request->name,
            'phone_number' => $request->phone,
            'email_address' => $request->email,
            'region' => $request->region,
            'city' => $request->city,
            'address' => $request->address,
            'deli_code'=> $request->deli_code
        ]);
        return response()->json(['code' => $request->deli_code]);
}
// Add to Order
public function addOrder(Request $request){
       $order = Order::create([
            'user_id' => $request->userId,
            'card_code' => $request->cardCode,
            'deli_code' => $request->deliCode,
            'total_price' => $request->total,
            'deli_price' => $request->deli
        ]);

        $orderId = $order->id;
        return response()->json(['orderId' => $orderId]);
}
// Show to Order lists
public function orderList(){
      $orderLists = Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
        // dd($orderLists->toArray());
        return view('user.Order.orderList',compact('orderLists'));
}
// Show to Order Detail
public function orderDetail($id){
        $productLists = Cart::select('carts.*','products.first_image','products.price','products.discount_price','orders.deli_price','orders.total_price')
                            ->leftJoin('products','carts.product_id','products.id')
                            ->leftJoin('orders','carts.order_code','orders.card_code')
                            ->where('carts.order_code',$id)->get();
        // dd($productLists->toArray());
        return view('user.Order.orderDetail',compact('productLists'));
}
// Show to Admin Order lists
public function adminOrderPage(){
        $orders = Order::select('orders.*','users.name')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->orderBy('created_at','DESC')
                        ->paginate(5);

        $homepayment = Order::where('payment','0')->get()->count();
        $cartpayment = Order::where('payment','1')->get()->count();
        $pending = Order::where('status','0')->get()->count();
        $success = Order::where('status','1')->orWhere('status','3')->get()->count();
        $reject = Order::where('status','2')->get()->count();
                        // dd($cartpayment);
        return view('admin.order.orderList',compact('orders','homepayment','cartpayment','pending','success','reject'));
}
// Show to Admin Order Detail
public function adminOrderDetail($id){
        $orderDetail = Order::select('orders.*','carts.product_id','carts.qty','carts.total','carts.size','products.name','products.first_image','products.price','products.discount_price','deliveries.full_name','deliveries.phone_number','deliveries.email_address','deliveries.region','deliveries.city','deliveries.address','payments.name as payName','payments.email as payEmail','payments.amount')
                            ->leftJoin('carts','orders.card_code','carts.order_code')
                            ->leftJoin('products','carts.product_id','products.id')
                            ->leftJoin('deliveries','orders.deli_code','deliveries.deli_code')
                            ->leftJoin('payments','orders.id','payments.order_id')
                            ->where('orders.id',$id)->get();
        // dd($orderDetail->toArray());
        return view('admin.order.orderDetail',compact('orderDetail'));
}
// To Change Order Status
public function orderStatusChange(Request $request){
        Order::where('id',$request->orderId)->update([
            'status' => $request->status
        ]);
  //-------------- notification for reject
      if($request->status == '2'){

        $code = Order::where('id',$request->orderId)->select('card_code','user_id')->first();
        $customerId = $code->user_id;
        $customer = User::where('id',$customerId)->first();

        $order_code = $code->card_code;
        $adminId = Auth::user()->id;
        $adminName = User::where('id',$adminId)->first()->name;
        logger($adminName);

        $title = 'Reject for Order';
        $message = ' Order Code '. $order_code .' rejected from our website . You can ask from our website messenger to Admin '.$adminName. ' Thank you .';
        $admin_id = $adminId;

        Notification::send($customer, new OrderNotification($title, $message, $admin_id));
      }
  // ---------------  Noti end
        return response()->json();
}
// To filter order status
public function orderFilterStatus(Request $request){
        logger($request->all());
        if($request->status == 'all'){
            return response()->json(['data' => 'all']);
        }else{
            $orders = Order::select('orders.*','users.name')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->where('orders.status',$request->status)
                        ->orderBy('created_at','DESC')
                        ->get();
        return response()->json($orders);
        }
}
// To filter payment status
public function orderFilterPayment(Request $request){
        logger($request->all());
        if($request->status == 'all'){
            return response()->json(['data' => 'all']);
        }else{
            $orders = Order::select('orders.*','users.name')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->where('orders.payment',$request->status)
                        ->orderBy('created_at','DESC')
                        ->get();
        return response()->json($orders);
        }
}
}
