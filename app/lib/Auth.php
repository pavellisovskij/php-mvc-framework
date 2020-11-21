<?php

namespace app\lib;

class Auth
{
    public static function setAuthorizedUser(array $user)
    {
        $_SESSION['user']['name'] = $user['username'];
        $_SESSION['user']['id']   = $user['id'];
    }

    public static function check()
    {
        if (isset($_SESSION['user'])) return true;
        else return false;
    }

    public static function unsetAuthorizedUser()
    {
        unset($_SESSION['user']);
    }

    public static function username() {
        return $_SESSION['user']['name'];
    }

    public static function id() {
        return $_SESSION['user']['id'];
    }
}