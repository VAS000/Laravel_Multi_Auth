<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Mail\AdminResetPassword;
use DB;
use Carbon\Carbon;
use Mail;

class AdminAuth extends Controller
{
    public function login() {
        if(admin()->check()) {
            return redirect(admin_url());
        }
        return view('admin.login');
    }

    public function postLogin() {

        $remember_me = request('remember_me') == 1 ? true: false;

        if(auth()->guard('admin')->attempt([
            'email' => request('email'),
            'password' => request('password'),
        ], $remember_me)) {
            return redirect(admin_url());
        }else {
            session()->flash('error', trans('admin.invalid_login_credentials'));
            return redirect(admin_url('login'));
        }
    }

    public function postLogout() {
        auth()->guard('admin')->logout();
        request()->session()->regenerateToken();
        return redirect(admin_url('login'));
    }

    public function forgetPassword() {
        return view('admin.forgot_password');
    }

    public function postForgetPassword() {

        if(!request('email')) {
            return back()->with('error', 'Email is required.');
        }

        $admin = Admin::where('email', request('email'))->first();
        if(!empty($admin)) {
            $token = app('auth.password.broker')->createToken($admin);
            $data = DB::table('password_resets')->insert([
                'email' => $admin->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            try {
                Mail::to($admin->email)->send(new AdminResetPassword([
                    'admin' => $admin,
                    'token' => $token,
                ]));

                if(count(Mail::failures()) > 0) {
                    throw new \Exception('Error sending email.');
                }else {
                    return back()->with('success', 'please check your email.');
                }
            }catch(\Exception $e) {
                return back()->with('error', 'Could not send email.')->withInput();
            }

        }else {
            return back()->with('error', 'Email not found.');
        }

        return back();
    }

    public function resetPassword($token) {
        $check_token = DB::table('password_resets')
            ->where('token', $token)
            ->where('created_at', '>', Carbon::now()->subHours(2))->first();

        if(!empty($check_token)) {
            return view('admin.reset_password')->with('reset_token', $token);
        }else {
            session()->flash('error', 'Invalid/Expired link, please request a new one.');
            return redirect(admin_url('forgot/password'));
        }
    }

    public function postResetPassword(){

        $validate = $this->validate(request(), [
            'email' => 'required',
            'reset_token' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ], [], [
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Password confirmation',
            'reset_token' => 'Password reset token',
        ]);

        $token = request('reset_token');
        $email = request('email');

        $check_token = DB::table('password_resets')
        ->where('token', $token)
        ->where('created_at', '>', Carbon::now()->subHours(2))->first();
        try {
            if(!empty($check_token)) {

                if($check_token->email != $email){
                    return back()->withErrors('Email address does not match our records');
                }

                $admin = Admin::where('email', $email)->update([
                    'password' => bcrypt(request('password')),
                ]);

                if(!$admin) {
                    throw new \Exception('Error resetting password, please try again.');
                }

                DB::table('password_resets')->where('email', $email)->delete();
                session()->flash('success', 'Password has been changed successfully. You can now login');
                return redirect(admin_url('login'));

                // if(admin()->attempt([
                //     'email' => $email,
                //     'password' => request('password')
                // ], true)){
                //     return redirect(admin_url());
                // }

                // return view('admin.reset_password')->with('reset_token', $token);
            }else {
                session()->flash('error', 'Invalid/Expired link, please request a new one.');
                return redirect(admin_url('forgot/password'));
            }
        }catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

}
