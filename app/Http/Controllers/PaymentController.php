<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
// Choose Payment page
public function choosePayment(Request $request){
        $order = Order::where('id',$request->data)->first();
        $qty = $request->quantity;
        // dd($qty);
        return view('user.Order.choosePayment',compact('order','qty'));
}
//payment page
public function paymentPage(Request $request){

        $order = Order::where('id',$request->id)->first();
        $price = $order->total_price;
        $product = $order->card_code;
        $deli = $order->deli_price;
        $user = $order->user_id;
        $total = $price + $deli;
        // dd($total);

        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
           $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                'price_data' => [
                    'currency' => 'mmk',
                    'product_data' => ['name' => "NS shop"],
                    'unit_amount' => $total*100,
                ],

                'quantity' => 1,
                ],
            ],

            'mode' => 'payment',
            'success_url' => route('user#paymentSuccess').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('user#paymentCancel'),
            ]);
            // dd($response);
            if(isset($response->id) && $response->id !== ''){
                session()->put('order_id',$request->id);
                session()->put('user_id',$user);
                session()->put('price',$total);
                return redirect($response->url);
            }else{
                return redirect()->route('user#paymentCancel');
            }
}


public function paymentSuccess(Request $request){
       if(isset($request->session_id)){
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
        $response = $stripe->checkout->sessions->retrieve($request->session_id);
    //    dd($response);
        Payment::create([
            'order_id' => session()->get('order_id'),
            'user_id' => session()->get('user_id'),
            'amount' => session()->get('price'),
            'name' => $response->customer_details->name,
            'email' =>$response->customer_details->email
        ]);
         Order::where('id',session()->get('order_id'))->update([
            'payment' => 1
         ]);
        return redirect()->route('user#orderList');
       }else{
        return redirect()->route('user#paymentCancel');
       }
    }

    public function paymentCancel(Request $request){
        return 'Payment is canceled';
    }
}
