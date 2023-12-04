<?php

namespace Dudyali\SsoBappenasLib;

define('SERVER_HOST', 'https://sso-server.dev-aplikasi.dev');

define('API_ENDPOINT', '/login');

class SSO 
{
    public static function authenticate()
    {
        redirect(SERVER_HOST.API_ENDPOINT)->send();
        exit();
    }

    public static function getUser()
    {
        return "on development";
    }

    public static function check()
    {
        return "on development";
    }

    public static function logout()
    {
        return "on development";
    }
}

