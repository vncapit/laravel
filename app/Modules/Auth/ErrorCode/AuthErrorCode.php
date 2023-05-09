<?php
/**
 * Created by PhpStorm
 * User: Cap
 * Date: 2023/05/09 16:14
 */

namespace App\Modules\Auth\ErrorCode;


class AuthErrorCode
{
    const USERNAME_OR_PASSWORD_INCORRECT = -2001;

    private static $text = [
        self::USERNAME_OR_PASSWORD_INCORRECT => 'USERNAME_OR_PASSWORD_INCORRECT',
    ];

    public static function getText($code)
    {
        return self::$text[$code];
    }
}
