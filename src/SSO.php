<?php

namespace Dudyali\SsoBappenasLib;

use Illuminate\Support\Str;

class SSO
{
    public static function authenticate()
    {
        request()->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'redirect_uri' => url('sso/callback'),
            'response_type' => 'code',
            'scope' => 'view-user ',
            'state' => $state,
            'prompt' => true,
        ]);

        redirect(config('sso_config.sso_host').'/request?'.$query)->send();

        exit();
    }

    public static function getUser()
    {
        return 'on development';
    }

    public static function check()
    {
        return 'on development';
    }

    public static function logout()
    {
        return 'on development';
    }
}
