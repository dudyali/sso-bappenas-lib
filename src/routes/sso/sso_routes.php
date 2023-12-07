<?php
use Illuminate\Support\Facades\Route;
use Dudyali\SsoBappenasLib\SSOController;


Route::group([
    'prefix'     => 'sso',
    'name'     => 'sso.',
], function () { // custom admin routes
    Route::get("login", [SSOController::class, 'getLogin']);
    Route::get("callback", [SSOController::class, 'getCallback'])->name("callback");
    Route::get("connect", [SSOController::class, 'connectUser'])->name("connect");
    Route::get("callback-session", [SSOController::class, 'getCallbackSession'])->name("callback.session");
    Route::get("logout", function(){
        auth()->logout();
        return redirect('login');
    });
    
    Route::get('logout-user',[SSOController::class,'logout']);
}); // this should be the absolute last line of this file

Route::get('home',[SSOController::class,'logout']);
?>