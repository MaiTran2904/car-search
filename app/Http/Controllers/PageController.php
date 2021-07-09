<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
class PageController extends Controller
{
    public function getIndex(){
        $slide = Slide::all();
        $new_product = Product::where('new',1)->get();
        $products = Product::where('new',0)->get();
        return view('page.trangchu',compact('slide','new_product','products'));
    }

    public function getLogin(){
       
        return view('login');
    }

    public function getSignup(){
       
        return view('signup');
    }


    public function postSignup(Request $req){
        $this->validate($req,
        ['email'=>'required|email|unique:users,email',
        'password'=>'required|min:6|max:20',
        'fullname'=>'required',
        'repassword'=>'required|same:password'
    ],
    [
        'email.required'=>'Vui lòng nhập email',
        'email.email'=>'Không nhập đúng định dạng email',
        'email.unique'=>'Email đã có người sử dụng',
        'password.required'=>'Vui lòng nhập mật khẩu',
        'repassword.same'=>'Mật khẩu không giống nhau',
        'passowrd.min'=>'Mật khẩu it nhất 6 ký tự'
    ]);
        $user=new User();
        $user->full_name=$req->fullname;
        $user->email=$req->email;
        $user->password=Hash::make($req->password);
        // $user->phone=$req->phone;
        // $user->address=$req->address;
        // $user->level=2;
        $user->save();
        return redirect('/login')->with('success','Tạo tài khoản thành công');
    }

   
    public function postLogin(Request $req)
    {
        $this->validate($req,
        ['email'=>'required|email',
        'password'=>'required|min:6|max:20'
        ],
        [
            'email.required'=>'Vui lòng nhập email',
            'email.email'=>'Không nhập đúng định dạng email',
            'email.unique'=>'Email đã có người sử dụng',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu it nhất 6 ký tự'
        ]);
        $credentials=array('email'=>$req->email,'password'=>$req->password);
        if(Auth::attempt($credentials)){
            return redirect('/index')->with(['flag'=>'alert','message'=>'Đăng nhập thành công']);
        }else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
        }
        
    }

    public function addToCart(Request $request,$id){
    	$product=Product::find($id);
    	$oldCart=Session('cart')?Session::get('cart'):null;
    	$cart=new Cart($oldCart);
    	$cart->add($product,$id);
    	$request->session()->put('cart',$cart);
    	return redirect()->back();
    }

    public function addManyToCart(Request $request,$id){
    	$product=Product::find($id);
    	$oldCart=Session('cart')?Session::get('cart'):null;
    	$cart=new Cart($oldCart);
    	$cart->addMany($product,$id,$request->qty);
    	$request->session()->put('cart',$cart);
    	
    	return redirect()->back();
    }

    public function delCartItem($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart -> removeItem($id);
        if(count($cart->items)>0){
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
        return redirect()->back();
    
    }

    function getCheckout() {
        return view('page.checkout');
    }
}

