<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\ProductType;
use App\Http\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        //
    }

   
    public function boot()
    {
        Paginator::useBootstrap();
        View::composer(['header','loaisp'], function ($view) {
            $producttypes=ProductType::all();
            //truyền biến $producttypes cho view header thông qua biến $view
            $view->with('producttypes',$producttypes);
        });

        //chia sẻ biến Session('cart') cho các view header.blade.php và checkout.php
        View::composer(['header','checkout'],function($view){
            if(Session('cart')){
                $oldCart=Session::get('cart'); //session cart được tạo trong method addToCart của PageController
                $cart=new Cart($oldCart);
                $view->with(['cart'=>Session::get('cart'),'productCarts'=>$cart->items,'totalPrice'=>$cart->totalPrice,'totalQty'=>$cart->totalQty]);
            }
        });
    }
}
