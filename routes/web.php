<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeliController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FlashSaleController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SingleProductController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\RatingAndQuestionController;


// localization section --------------------------
Route::get('localization/{locale}',[LocalizationController::class,'setlocate'])->name('localization');
Route::middleware('localization')->group(function () {

// Welcome & Login section -------------------------
Route::middleware('login_middleware')->controller(AuthController::class)->group(function () {
    // welcome
     Route::get('/','welcome')->name('welcome');
    // login Register
    Route::get('loginPage','login')->name('loginPage');
    Route::get('registerPage','register')->name('registerPage');
    // Facebook Login
    Route::get('auth/facebook','facebook')->name('facebookLogin');
    Route::get('auth/facebook/callback','facebookLogin');
    // Google Login
    Route::get('auth/google','google')->name('googleLogin');
    Route::get('auth/google/callback','googleLogin');
    // OTP Login
    Route::get('OTP/login','otplogin')->name('otp#Login');
    Route::post('OTP/send','otpPost')->name('otp#post');
    Route::get('OTP/Code/{id}','otpCode')->name('otp#code');
    Route::post('OTP/Code/Post','otpCodePost')->name('otp#codePost');
    // Forget Password
    Route::get('forget/password','forget')->name('forgetPassword');
    Route::post('forget/password','sendEmail')->name('sendEmail');
    Route::get('email/send/{token}','email')->name('email');
    Route::post('password/update','updatePassword')->name('passwordUpdate');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard',[AuthController::class,'choose'])->name('choosePage');

// Admin section ----------------------------
Route::prefix('admin')->middleware('admin_middleware')->group(function () {

//*************** */ Profile and home Page *********************
Route::controller(AdminController::class)->group(function(){
    Route::get('home','home')->name('admin#homePage');
    // Profile
    Route::get('profile/detail','show')->name('admin#profileShow');
    Route::get('profile/edit','edit')->name('admin#profileEdit');
    Route::post('profile/update','update')->name('admin#profileUpdate');
    //Password
    Route::get('password/edit','passwordEdit')->name('admin#passwordEdit');
    Route::post('password/update','passwordUpdate')->name('admin#passwordUpdate');
});
//************************* * Category*********************************
Route::controller(CategoryController::class)->group(function(){
       // create
    Route::get('category','create')->name('category#create');
    Route::post('category/create','categoryPost')->name('category#post');
    Route::post('subCategory/create','subcategory')->name('subcategory#post');
    // show
    Route::get('category/show','show')->name('category#show');
    // delete
    Route::get('category/delete/{id}','delete')->name('category#delete');
    Route::post('subcategory/delete','subdelete')->name('subcategory#delete');
    // Update
    Route::get('category/edit{id}','edit')->name('category#edit');
    Route::post('category/update','update')->name('category#update');
    Route::get('subCategory/edit{id}','subedit')->name('subcategory#edit');
    Route::post('subCategory/update','subupdate')->name('subcategory#update');
    });
// ************************* Product *************************************
Route::controller(ProductController::class)->group(function(){
        // create
    Route::get('product','create')->name('product#create');
    Route::post('product/post','createPost')->name('product#createPost');
    // show
    Route::get('product/show','show')->name('product#show');
    // delete
    Route::get('product/delete/{id}','delete')->name('product#delete');
    Route::get('product/image/{id}','imageDelete')->name('product#imgDelete');
    // detail & update
    Route::get('product/detail/{id}','detail')->name('product#detail');
    Route::post('product/update','update')->name('product#update');
    // discount section
    Route::post('product/discount','discount')->name('product#discount');
    // rating show
    Route::get('rating/show/{ids}','ratingShow')->name('product#rating');

});
//**************************** */ Flash Sale Product **********************
Route::controller(FlashSaleController::class)->group(function(){
    Route::get('flash/sale/page','FlashSalePage')->name('flashSalePage');
    Route::post('flash/sale/save','flshSaleSave')->name('flashSaleSave');
    Route::get('flash/sale/delete','flashSaleDelete');
});
//********************** * notification *************
Route::controller(NotificationController::class)->group(function(){
    // Rating and review
    Route::get('notification/show','adminNotiShow')->name('admin#notiShow');
    Route::get('notification/detail','adminNotiDetail');
    Route::post('noti/read/delete','adminNotiDelete')->name('admin#notiDelete');
    Route::get('noti/rating/delete/{id}','adminRatingReadDelete')->name('admin#ratingSoloDelete');
    Route::get('noti/read','adminNotiRead');

    // Question And Reply
    Route::get('noti/question/show','adminquestionShow')->name('admin#notiQuesShow');
    Route::get('noti/question/detail','adminquestDetail');
    Route::get('noti/reply','adminReply');
    Route::get('noti/delete/{id}','notireadDelete')->name('admin#notireadDelete');
    Route::get('read/allDelete','questionDelete')->name('admin#readquesDelete');

    Route::get('question/lists','questionLists')->name('admin#questionLists');
    Route::get('question/list/delete/{id}','questionListDelete')->name('admin#questionlistDelete');
    Route::get('question/list/edit/{id}','questionListEdit')->name('admin#questionlistEdit');
    Route::post('question/list/update','questionUpdate')->name('admin#questionListUpdate');
});
//*************************** * Order Notification to Admin ************
Route::controller(OrderController::class)->group(function(){
    Route::get('order/page','adminOrderPage')->name('admin#orderPage');
    Route::get('order/detail/{id}','adminOrderDetail')->name('admin#orderDetailPage');

    Route::get('orderChange/status','orderStatusChange');
    Route::get('orderFilter/status','orderFilterStatus');
    Route::get('orderFilter/payment','orderFilterPayment');
});
//*************************** */ member lists ***************************
Route::controller(MemberController::class)->group(function(){
    Route::get('userlists','userlistsPage')->name('admin#userlistsPage');
    Route::get('change/userlist','userlistChange');

    Route::get('adminlists','adminlistsPage')->name('admin#adminlistPage');
    Route::get('delilists','delilistsPage')->name('admin#delilistPage');
});
//*********************** */ Delivery send *******************
Route::controller(DeliController::class)->group(function(){
    Route::get('choose/delivery/{id}','chooseDeliPage')->name('admin#chooseDeli');
    Route::get('deli/send','deliSend');
});
// ********************* Post Create **********************
Route::controller(PostController::class)->group(function(){
    Route::get('post/create','postCreate')->name('admin#postCreate');
    Route::post('post/create','createPost')->name('admin#createPost');
    Route::get('post/delete/{id}','deletPost')->name('admin#deletePost');
    Route::get('post/detail/{id}','detailPost')->name('admin#detailPost');
    Route::get('post/edit/{id}','postEdit')->name('admin#postEdit');
    Route::get('post/image/{name}','postimageDelete')->name('admin#postImageDelete');
    Route::post('post/update','postUpdate')->name('admin#updatePost');
});

});

// Delivery Section ----------------------------------
Route::prefix('deli')->middleware('deli_middleware')->controller(DeliController::class)->group(function(){
    Route::get('home','home')->name('deli#homePage');
    Route::get('profile/page','profilePage')->name('deli#profilePage');
    Route::get('profile/edit','profileEdit')->name('deli#profileEdit');
    Route::post('profile/update','profileUpdate')->name('deli#profileUpdate');

    Route::get('email/edit','emailEdit')->name('deli#emailEdit');
    Route::post('password/check','psCheck')->name('deli#psCheck');
    Route::post('email/update','emailUpdate')->name('deli#emailUpate');

    Route::get('password/edit','psEdit')->name('deli#psEdit');
    Route::post('password/update','psUpdate')->name('deli#psUpdate');

    Route::get('detail/{id}','deliDetail')->name('deli#detailPage');
    Route::get('status/change','deliStateChange');
    Route::get('status/filter','deliFilterState');
});

// User section ------------------------------------------
Route::prefix('user')->middleware('user_middleware')->group(function () {

//***************** */ User Profile and welcome ***********************
Route::controller(UserController::class)->group(function(){
        Route::get('homePage','home')->name('user#homePage');
        // Profile and password
        Route::get('profile/show','pfshow')->name('user#profileShow');
        Route::get('profile/edit','pfedit')->name('user#profileEdit');
        Route::post('profile/update','pfupdate')->name('user#UpdateProfile');

        Route::get('change/password','pschange')->name('user#passwordChange');
        Route::post('update/password','psupdate')->name('user#passwordUpdate');

        Route::get('email/edit','emedit')->name('user#emailEdit');
        Route::post('check/password','checkpassword')->name('user#checkps');
        Route::post('email/update','emupdate')->name('user#emailUpdate');
    });
//****************** */ Rating and Question *****************************
Route::controller(RatingAndQuestionController::class)->group(function () {
        Route::get('rating/show/page','rating')->name('user#ratingshowPage');
        Route::get('rating/delete/{id}','ratingDelete')->name('user#ratingDelete');
        // question comment
        Route::get('comment/send','comment');
    });
//************************** */ Heart to show ***************************
Route::controller(SingleProductController::class)->group(function (){
        Route::get('add/heart','heart');
        Route::get('show/whislist','heartLists')->name('user#heartLists');
        Route::get('delete/whislist/{id}','heartDelete')->name('user#heartDelete');
        // Add to Card
        Route::post('add/card','addtoCart')->name('user#addCart');
        Route::get('cardList/show','cardListShow')->name('user#cardListShow');

        Route::get('card/all/delete','cartAllDelete')->name('user#cardAllDelete');
        Route::get('card/solo/delete/{id}','cartSoloDelete')->name('user#cartSoloDelete');

        Route::get('add/original/card','addCart');
        Route::get('add/buy/button','buyaddCart');
    });
//************************** */ Order and Delivery ***********************
Route::controller(OrderController::class)->group(function (){
        Route::get('delivery/page','deliveryPage')->name('user#deliveryPage');
        Route::get('delivery/page/buy','deliveryBuyPage');

        Route::get('add/delviery','addDelivery');
        Route::get('add/order','addOrder');

        Route::get('order/list','orderList')->name('user#orderList');
        Route::get('order/detail/{id}','orderDetail')->name('user#orderDetail');
    });
//******************** */ Payment section ************************
Route::controller(PaymentController::class)->group(function(){
        Route::get('choose/payment','choosePayment');
        Route::post('payment/page','paymentPage')->name('user#paymentHomePage');
        Route::get('payment/success','paymentSuccess')->name('user#paymentSuccess');
        Route::get('payment/cancel','paymentCancel')->name('user#paymentCancel');
    });


//********************** */ Notification ***************************
Route::controller(UserNotificationController::class)->group(function(){
        // Answers for comments
        Route::get('noti/page','notiPage')->name('user#notiPage');
        Route::get('noti/detail','detail');
        Route::get('noti/read','read');
        Route::get('noti/read/solo/delete/{id}','soloDelete')->name('user#soloDelete');

        // Reject Order Noti
       Route::get('order/noti','orderNotiPage')->name('user#ordernotiPage');
       Route::get('order/noti/detail','orderNotiDetail');
       Route::get('order/noti/read','orderNotiRead');
    });

});

});

// All section ------------------------------------
//***************** */  Products list **************************
Route::controller(WelcomeController::class)->group(function () {
    Route::get('product/lists/{id}','productlists')->name('productList');
    Route::get('pagination/product','paginateProduct');
    Route::get('searchBar','search')->name('productList#searchBar');
    // Filter section
    Route::get('pagination/fetch_data',[AuthController::class,'fetch_data']);
    Route::get('pagination/sorting','price');
    Route::get('pagination/brand','brand');
    Route::get('pagination/minmax/price','betweenPrice');
    Route::get('pagination/sorting/review','reviewhight');
    Route::get('pagination/sorting/review/low','reviewlow');
});
//************************ */ Product Single Page **********************
Route::controller(SingleProductController::class)->group(function () {
    Route::get('product/single/{id}','singlePage')->name('productSinglePage');
    // view count
    Route::get('view/count','viewCount');
});
 //************************* */ Rating and Review ************************
Route::controller(RatingAndQuestionController::class)->group(function () {
        Route::get('rating/review','ratingInput');
        Route::get('rating/review/get','ratingGet');
        Route::get('check/product','checkProduct');
        Route::get('rating/pagination','ratingPagination');
});
//**************************Post Section ***********************
Route::controller(PostController::class)->group(function(){
    Route::get('post/show','customerpostShow')->name('user#postShow');
    Route::get('post/like','postLike');
    Route::get('post/unlike','postunLike');
});
});

