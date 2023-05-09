<?php
/**
 * Created by PhpStorm
 * User: Cap
 * Date: 2023/05/09 13:15
 */

namespace App\Modules\User\ErrorCode;


class UserErrorCode
{
    const USERNAME_EXISTED = -1001;
    const USER_NOT_EXIST = -1002;

    private static $text = [
        self::USERNAME_EXISTED => 'USERNAME_EXISTED',
        self::USER_NOT_EXIST => 'USER_NOT_EXIST',
    ];

    public static function getText($code)
    {
        return self::$text[$code];
    }
}
