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

    public static function MIN_LENGTH_PASSWORD(){
        return '2';
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

    public static function SYS_RC_INVALID_NEW_PASSWORD_CONFIRM_PASSWORD(){
        return 'rc.9';
    }
    public static function SYS_MSG_INVALID_NEW_PASSWORD_CONFIRM_PASSWORD(){
        return __('lang.'.Constants::SYS_RC_INVALID_NEW_PASSWORD_CONFIRM_PASSWORD());
    }

    public static function SYS_RC_INVALID_MIN_PASSWORD_LENGTH(){
        return 'rc.10';
    }
    public static function SYS_MSG_INVALID_MIN_PASSWORD_LENGTH($minPasswordLength){
        return __('lang.'.Constants::SYS_RC_INVALID_MIN_PASSWORD_LENGTH(),['minLength' => $minPasswordLength]);
    }

    public static function SYS_RC_INVALID_PASSWORD_FORMAT(){
        return 'rc.11';
    }
    public static function SYS_MSG_INVALID_PASSWORD_FORMAT(){
        return __('lang.'.Constants::SYS_RC_INVALID_PASSWORD_FORMAT());
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
    public static function SYS_MSG_RESET_PASSWORD_SUCCESS_CHANGED(){
        return __('lang.resetPassword.msg.success');
    }
    public static function SYS_MSG_SYSTEM_SETTING_SUCCESS_EDITED(){
        return __('lang.systemSetting.msg.success.edit');
    }
    public static function SYS_MSG_PROFILE_SETTING_SUCCESS_EDITED(){
        return __('lang.profileSetting.msg.success.edit');
    }
    public static function SYS_MSG_LABEL_SETTING_SUCCESS_EDITED(){
        return __('lang.sablonbalon.labelSetting.msg.success.edit');
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
