<?php

namespace App;

class UserTypes
{
    public static $user = "user";
    public static $admin = "admin";

    public static function allTypes() {
        return array(self::$user, self::$admin);
    }

}