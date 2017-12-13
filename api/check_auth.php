<?php
/**
 * Created by PhpStorm.
 * User: schut
 * Date: 13.12.2017
 * Time: 3:18
 */


function isRequestAuthorized($db, $token)
{
    $user = new User($db);
    $user->token = $token;

    $user->readByToken();

    return $user->id != null;
}

function getTokenFromHeader()
{
    foreach ($_SERVER as $k => $v) {
        if (substr($k, 0, 17) == "HTTP_X_AUTH_TOKEN") {
            $k = str_replace('_', ' ', substr($k, 17));
            $k = str_replace(' ', '-', ucwords(strtolower($k)));
            return $v;
        }
    }
    return null;
}