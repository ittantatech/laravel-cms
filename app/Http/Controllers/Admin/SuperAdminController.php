<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('dashboard');
        
        return view('admin.pages.dashboard');
    }

    public function profile(){
        $user =Auth::user();
        return view('admin.pages.profile',compact('user'));   
    } 

    public function updateProfile(Request $request){
        $user = Auth::user();
        $id=$user->id;
        $rules=[
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id,id",
            'password' => 'nullable|string|min:6|confirmed'
        ];
        $request->validate($rules);
        $user->name=$request->get('name');
        $user->email=$request->get('email');
        $password = $request->get('password','');
        if(!empty($password)){
            $user->password =bcrypt($password);
        }
        $user->save();
        flash("Profile updated!")->success();
        return redirect()->back();
        
        
    }  
}
