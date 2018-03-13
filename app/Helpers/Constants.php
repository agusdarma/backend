<?php

namespace App\Helpers;

class Constants
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public static function SYS_RC_EMAIL_NOT_FOUND(){
        return 'rc.1';
    }

    public static function SYS_MSG_EMAIL_NOT_FOUND(){
        return __('lang.'.Constants::SYS_RC_EMAIL_NOT_FOUND());
    }

    public static function SYS_RC_PASSWORD_NOT_MATCH(){
        return 'rc.2';
    }

    public static function SYS_MSG_PASSWORD_NOT_MATCH(){
        return __('lang.'.Constants::SYS_RC_PASSWORD_NOT_MATCH());
    }
}
