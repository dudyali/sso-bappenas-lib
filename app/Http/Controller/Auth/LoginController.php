<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Dudyali\SsoBappenasLib\SSOHelper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends \App\Http\Controllers\Auth\LoginController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

   
    public function logout(Request $request)
    {
        if(session()->get("access_token") != ''){
            SSOHelper::logoutFromSSO();
            Auth::logout();

            $urlSso = config('sso_config.sso_host');
            return redirect($urlSso.'/logout-api');
        }
        Auth::logout();
        // return $request;
        return redirect('login')->with('success','Anda Berhasil Logout');
    }
}
