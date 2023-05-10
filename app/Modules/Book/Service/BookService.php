<?php


namespace App\Modules\Book\Service;


use App\Models\Book;
use App\Modules\Book\ErrorCode\BookErrorCode;

class BookService
{
    public function __construct()
    {

    }

    public function createBook(Book $book)
    {
        $checkBook = Book::whereTitle($book->title)->first();
        if ($checkBook){
            return BookErrorCode::BOOK_CREATE_FAILED;
        }
        return $book->save();
    }

    public function deleteBook($id)
    {
        return Book::destroy($id);
    }
}
