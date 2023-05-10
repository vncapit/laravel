<?php


namespace App\Modules\Category\ErrorCode;


class CategoryErrorCode
{
    const CATEGORY_CREATE_FAILED = -3001;

    private static $text = [
        self::CATEGORY_CREATE_FAILED => 'CATEGORY_CREATE_FAILED',
    ];

    public static function getText($code)
    {
        return self::$text[$code];
    }
}
