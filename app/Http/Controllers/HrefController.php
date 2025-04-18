<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HrefController extends Controller
{
    public function gotoIndex(){
        return view('index');
    }

    public function gotoLogin(){
        return view('auth.login');
    }

    public function gotoRegister(){
        return view('auth.register');
    }
}
