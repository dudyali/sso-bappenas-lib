<?php

namespace Dudyali\SsoBappenasLib;

define('SERVER_HOST', 'https://sso-server.dev-aplikasi.dev');

define('API_ENDPOINT', '/login');

class SSO 
{
    public static function redirect()
    {
        redirect(SERVER_HOST.API_ENDPOINT)->send();
        exit();
    }
}

