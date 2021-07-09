<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function getLogin()
    {
        return view('admin.login');
    }


    public function postLoginAd(Request $req){
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

    public function getSignupAd(){
       
        return view('admin.register');
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

    public function getLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.getLogin');
    }
}