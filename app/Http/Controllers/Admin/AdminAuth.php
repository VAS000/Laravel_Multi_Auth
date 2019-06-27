<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminAuth extends Controller
{
    public function login() {
        return view('admin.login');
    }

    public function postLogin() {

        $remember_me = request('remember_me') == 1 ? true: false;

        if(auth()->guard('admin')->attempt([
            'email' => request('email'),
            'password' => request('password'),
        ], $remember_me)) {
            return redirect('admin');
        }else {
            session()->flash('error', trans('admin.invalid_login_credentials'));
            return redirect('admin/login');
        }
    }

    public function postLogout() {
        auth()->guard('admin')->logout();
        return redirect('admin/login');
    }
}
