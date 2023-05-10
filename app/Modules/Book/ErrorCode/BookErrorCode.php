<?php


namespace App\Modules\Book\ErrorCode;


class BookErrorCode
{
    const BOOK_CREATE_FAILED = -3001;

    private static $text = [
        self::BOOK_CREATE_FAILED => 'BOOK_CREATE_FAILED',
    ];

    public static function getText($code)
    {
        return self::$text[$code];
    }
}
