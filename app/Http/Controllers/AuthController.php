<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\OTPLogin;
use App\Models\Promotion;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use App\Models\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthController extends Controller
{
//login page
public function login(){
        return view('loginRegister.login');
}
// register page
public function register(){
        return view('loginRegister.register');
}
// welcome page
public function welcome(){
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

                        // dd($product->toArray());
        return view('welcome',compact('product','subcategory','popular','promotion'));
}
// welcome pagination
public function fetch_data(Request $request){
        if($request->ajax()){
            $product = Product::select('products.*','ratings.rating','ratings.user_name',DB::raw('count(products.id) as total'))
                        ->leftJoin('ratings','ratings.product_id','products.id')
                        ->groupBy('products.id')
                        ->inRandomOrder()->paginate(12);
            return view('child_pagination', compact('product'))->render();
        }
}

//***************************** * facebook login ************
    public function facebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function facebookLogin(){
        try {
            $facebook_user = Socialite::driver('facebook')->user();
            //  dd($facebook_user);
            $user = User::where('facebook_id',$facebook_user->id)->first();
            //  dd($user);
             if(!$user){
                 $new_user = User::create([
                     'name' => $facebook_user->name,
                     'email' => $facebook_user->email,
                     'facebook_id' => $facebook_user->id,
                     'gender' => 'male'
                 ]);
                //  dd($new_user);
                 Auth::login($new_user);
                 return redirect()->route('choosePage');
             }else{
                 Auth::login($user);
                 return redirect()->route('choosePage');
             }

         } catch (\Throwable $th) {
             dd('Something wrong'.$th->getMessage());
         }
    }

//*********************************** * Google Login *******************
    public function google(){
        return Socialite::driver('google')->redirect();
    }
    public function googleLogin(){
        try{
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id',$google_user->id)->first();
            if(!$user){
                $new_user = User::create([
                    'name' => $google_user->name,
                    'email' => $google_user->email,
                    'google_id' => $google_user->id,
                    'gender' => 'male'
                ]);
                Auth::login($new_user);
                return redirect()->route('choosePage');
            }else{
                Auth::login($user);
                return redirect()->route('choosePage');
            }
        }catch(\Throwable $th){
            dd('Something wrong'.$th->getMessage());
        }
    }
// *********************************OTP Login*************************************
    public function otplogin(){
        return view('loginRegister.otpLogin');
    }
    public function otpPost(Request $request){
        Validator::make($request->all(),[
            'phone' => 'required|exists:users,phone'
        ])->validate();
       $Code = $this->generateOTP($request->phone);
       $code = "Your OTP code is _" . $Code->otp;
       return redirect()->route('otp#code',['id'=>$Code->user_id])->with(['message' => $code]);

    }
    public function otpCode($id){
        return view('loginRegister.otpCode',compact('id'));
    }
    public function otpCodePost(Request $request){
        Validator::make($request->all(),[
            'code' => 'required|exists:o_t_p_logins,otp'
        ])->validate();
        $code = OTPLogin::where('user_id',$request->userId)->where('otp',$request->code)->first();
        $now = Carbon::now();
        if($code && $now->isAfter($code->expired_time)){
            return back()->with(['error' => "Your OTP Code has been expired.Try Again!"]);
        }elseif($code){
            OTPLogin::where('user_id',$request->userId)->where('expired_time','<',$now)->delete();
            $user = User::whereId($request->userId)->first();
            Auth::login($user);
            return redirect()->route('choosePage');
        };
        return back()->with(['message' => 'OTP Code is not correct']);

    }
    private function generateOTP($phone){
        $user = User::where('phone',$phone)->first();
        $verifiCode = OTPLogin::where('user_id',$user->id)->latest()->first();
        // dd($verifiCode->toArray());
        $now = Carbon::now();
        if($verifiCode && $now->isBefore($verifiCode->expired_time)){
            return $verifiCode;
        };
        // dd($now->toArray);
        return OTPLogin::create([
            'user_id' => $user->id,
            'otp'  => rand(123456,999999),
            'expired_time' => Carbon::now()->addMinutes(5)
        ]);

    }


//  *********************************forget password start***********************

    public function forget(){
        return view('loginRegister.forgetPassword');
    }
    // email send
    public function sendEmail(Request $request){
        Validator::make($request->all(),[
            'email' => 'required|exists:users,email'
        ])->validate();

        $token = Str::random(50);
        ResetPassword::create([
            'email' => $request->email,
            'token' => $token
        ]);
        Mail::send('loginRegister.emailSend',['token' => $token],function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return back()->with(['success' => "We have send an email to reset password.If don't you get email,you check email correct "]);
    }
    // password change
    public function email($token){
        return view('loginRegister.newPassword',compact("token"));
    }

    public function updatePassword(Request $request){
       Validator::make($request->all(),[
        'email' => 'required|exists:users,email',
        'password' => 'required|min:6',
        'confirm' => 'required|same:password'
       ])->validate();

       $update = Resetpassword::where(['email' => $request->email,'token' => $request->token])->first();
      if(!$update){
        return back()->with(['error' => 'check your email.That is wrong!']);
      }else{
        User::where('email',$request->email)->update([
            'password' => Hash::make($request->password)
        ]);
        Resetpassword::where(['email' => $request->email,'token' => $request->token])->delete();
        return back()->with(['success'=> 'Password Reset success.Go to Login']);
      }

    }

// choose role
public function choose(){
        if(Auth::user()->role == 'admin'){
            return redirect()->route('admin#homePage');
        }elseif(Auth::user()->role == 'user'){
            return redirect()->route('user#homePage');
        }else{
            return redirect()->route('deli#homePage');
        }
}
}
