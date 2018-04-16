<?php

namespace App\Helpers;

class Constants
{
    public static function ASIA_TIMEZONE(){
      return 'Asia/Jakarta';
    }
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
    public static function SYS_RC_MENU_REQUIRED(){
        return 'rc.6';
    }
    public static function SYS_MSG_MENU_REQUIRED(){
        return __('lang.'.Constants::SYS_RC_MENU_REQUIRED());
    }
    public static function SYS_RC_USER_NOT_FOUND(){
        return 'rc.7';
    }
    public static function SYS_MSG_USER_NOT_FOUND(){
        return __('lang.'.Constants::SYS_RC_USER_NOT_FOUND());
    }
    public static function SYS_RC_INVALID_OLD_PASSWORD(){
        return 'rc.8';
    }
    public static function SYS_MSG_INVALID_OLD_PASSWORD(){
        return __('lang.'.Constants::SYS_RC_INVALID_OLD_PASSWORD());
    }
    public static function SYS_MSG_LEVEL_SUCCESS(){
        return 'success';
    }
    public static function SYS_MSG_USER_SUCCESS_ADDED(){
        return __('lang.user.msg.success');
    }
    public static function SYS_MSG_USER_SUCCESS_EDITED(){
        return __('lang.user.msg.success.edit');
    }
    public static function SYS_MSG_USER_LEVEL_SUCCESS_ADDED(){
        return __('lang.userLevel.msg.success');
    }
    public static function SYS_MSG_CHANGE_PASSWORD_SUCCESS_CHANGED(){
        return __('lang.changePassword.msg.success');
    }
    public static function SYS_MSG_USER_LEVEL_SUCCESS_EDITED(){
        return __('lang.userLevel.msg.success.edit');
    }
    public static function SYS_RC_UNKNOWN_ERROR(){
        return 'rc.98';
    }
    public static function SYS_MSG_UNKNOWN_ERROR(){
        return __('lang.'.Constants::SYS_RC_UNKNOWN_ERROR());
    }
    public static function SYS_RC_VALIDATION_INPUT_ERROR(){
        return 'rc.99';
    }
}
