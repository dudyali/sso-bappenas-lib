<?php

namespace Dudyali\SsoBappenasLib;

use Illuminate\Support\Facades\Http;

define('SERVER_HOST', env('SSO_HOST '));

define('API_ENDPOINT', '/login');

class SSOHelper
{
    public static function logoutFromSSO()
    {
        $access_token = session()->get("access_token");
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $access_token
        ])->get(config("auth.sso_host") .  "/api/logmeout");
    }
}