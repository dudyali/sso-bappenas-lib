<?php
use Illuminate\Support\Facades\Route;
use Dudyali\SsoBappenasLib\SSOController;

Route::get("/sso/login", [SSOController::class, 'getLogin'])->name("sso.login");
Route::get("/callback", [SSOController::class, 'getCallback'])->name("sso.callback");
Route::get("/sso/connect", [SSOController::class, 'connectUser'])->name("sso.connect");
Route::get("/callback-session", [SSOController::class, 'getCallbackSession'])->name("sso.callback.session");
Route::get("/sso/logout", function(){
    auth()->logout();
    return redirect('login');
});

Route::get('logout-user',[LoginController::class,'logout']);
?>