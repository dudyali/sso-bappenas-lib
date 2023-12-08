<?php
use Illuminate\Support\Facades\Route;


Route::get("/sso/login", [SSOController::class, 'getLogin'])->name("sso.login");
Route::get("/sso/callback", [SSOController::class, 'getCallback'])->name("sso.callback");
Route::get("/sso/connect", [SSOController::class, 'connectUser'])->name("sso.connect");
Route::get("/sso/callback-session", [SSOController::class, 'getCallbackSession'])->name("sso.callback.session");
Route::get("/sso/logout", function(){
    auth()->logout();
    return redirect('login');
});

Route::get('home',[SSOController::class,'logout']);
?>