<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Modules\Book\Service\BookService;
use App\Modules\Book\ErrorCode\BookErrorCode;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $bookService;
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function createBook(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'user_id' => 'required|int|exists:users,id',
            'year_published' => 'required|int|min:1900',
        ]);
        $book = new Book();
        $book->title = $request->title;
        $book->user_id = $request->user_id;
        $book->year_published = $request->year_published;

        $res = $this->bookService->createBook($book);
        if ($res !== BookErrorCode::BOOK_CREATE_FAILED) {
            return $this->success(1);
        }
        return $this->failed($res, BookErrorCode::getText($res));
    }

    public function deleteBook(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:books,id'
        ]);

        return $this->bookService->deleteBook($request->id);
    }
}
