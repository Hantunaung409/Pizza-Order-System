<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //direct login
    public function loginPage(){
        return view('loginPage');
    }

    //direct register page
    public function registerPage(){
        return view('registerPage');
    }

    //direct dashboard
    public function dashboard(){
        if(Auth::user()->role == 'admin'){
            return redirect()->route('category@list');
            //only route so error tat tal
        }else{
            return redirect()->route('user@home');
        }
    }

}
