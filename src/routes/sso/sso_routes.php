<?php

use Dudyali\SsoBappenasLib\SSOController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'sso',
    'name' => 'sso.',
], function () {
    Route::get('login', [SSOController::class, 'getLogin']);
    Route::get('callback', [SSOController::class, 'getCallback'])->name('callback');
    Route::get('connect', [SSOController::class, 'connectUser'])->name('connect');
    Route::get('callback-session', [SSOController::class, 'getCallbackSession'])->name('callback.session');
    Route::get('logout', function () {
        auth()->logout();

        return redirect('login');
    });

    Route::get('logout-user', [SSOController::class, 'logout']);
});

Route::get('home', [SSOController::class, 'logout']);
