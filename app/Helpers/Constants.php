<?php

namespace App\Helpers;

class Constants
{
    public static function MAX_INVALID_LOGIN(){
        return '1';
    }
    public static function CONSTANTS_SESSION_LOGIN(){
        return 'SESSION_LOGIN';
    }
    public static function CONSTANTS_ACTIVE(){
        return 'active';
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
    public static function SYS_RC_SESSION_EXPIRED(){
        return 'rc.3';
    }
    public static function SYS_MSG_SESSION_EXPIRED(){
        return __('lang.'.Constants::SYS_RC_SESSION_EXPIRED());
    }
    public static function SYS_RC_USER_NOT_ACTIVE(){
        return 'rc.4';
    }
    public static function SYS_MSG_USER_NOT_ACTIVE(){
        return __('lang.'.Constants::SYS_RC_USER_NOT_ACTIVE());
    }
    public static function SYS_RC_USER_BLOCKED(){
        return 'rc.5';
    }
    public static function SYS_MSG_USER_BLOCKED(){
        return __('lang.'.Constants::SYS_RC_USER_BLOCKED());
    }
}