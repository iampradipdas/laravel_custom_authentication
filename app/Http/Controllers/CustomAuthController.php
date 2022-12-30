<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;



class CustomAuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    public function registration(){
        return view('auth.registration');
    }
    public function saveUser(Request $request){
        $atr=$request->validate([
            'name'=>'required|max:30',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'cpassword'=>'required|same:password',
        ]);
        $obj=new User();
        $obj->name=$request->name;
        $obj->email=$request->email;
        $obj->password=Hash::make($request->password);
        $obj->cpassword=Hash::make($request->cpassword);
        $obj->save();

        // User::create($atr);
        if($request){
            return back()->with('success','You are registered successfully');
        }else{
            return back()->with('fail','Something Wrong');
        }

    }

    public function loginUser(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        $user=User::where('email','=',$request->email)->first();
        // echo $user;
        // die;
        if($user){
            if(Hash::check($request->password,$user->password)){
                $request->Session()->put('loginId',$user->id);
                return redirect('/dashboard');
            }
            else{
                return back()->with('fail','You enterrd wrong password');
            }

        }
        else{
            return back()->with('fail','Your mail id is not registered');
        }
    }

    public function dashboard(){
        if(Session()->has('loginId')){
            $data=User::where('id','=',Session()->get('loginId'))->first();
            return view('auth.dashboard',compact('data'));
        
        }
    }
    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('/login');
        }
    }
}
