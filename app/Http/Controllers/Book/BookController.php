<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Modules\Book\Service\BookService;
use App\Modules\Book\ErrorCode\BookErrorCode;
use Illuminate\Http\Request;
use App\Jobs\TestLog;

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

    public function addBookToCategory(Request $request)
    {
        $this->validate($request, [
            'book_id' => 'required|int|exists:books,id',
            'category_id' => 'required|int|exists:categories,id'
        ]);

        $book = Book::find($request->book_id);
        $book->categories()->syncWithoutDetaching($request->category_id);
    }

    public function removeBookFromCategory(Request $request)
    {
        $this->validate($request, [
            'book_id' => 'required|int|exists:books,id',
            'category_id' => 'required|int|exists:categories,id'
        ]);

        $category = Category::find($request->category_id);
        return $category->books()->detach($request->book_id);
    }

    public function addComment(Request $request)
    {
        $this->validate($request, [
            'book_id' => 'required|int|exists:books,id',
            'comment' => 'required|string'
        ]);

        $book = Book::find($request->book_id);
        $comment = new Comment();
        $comment->content = $request->comment;
        $comment->user_id = api_user_model()->id;
        return $book->comments()->save($comment);
    }

    public function getAllComments(Request $request)
    {
        $this->validate($request, [
            'book_id' => 'required|int|exists:books,id',
        ]);

        $book = Book::find($request->book_id);
        $comments = $book->comments()->get();

        // write comment to log:
        TestLog::dispatch($comments);
        return $comments;
    }

    public function findBooks(Request $request)
    {
        $this->validate($request, [
            'book_id' => 'nullable|int|exists:books,id',
            'title' => 'nullable|string',
            'author_id' => 'nullable|int|exists:users,id',
            'year_published' => 'nullable|int',
            'category_id' => 'nullable|int|exists:categories,id',
            'category' => 'nullable|string',
            'comment' => 'nullable|string'
        ]);

        $book_id = $request->book_id;
        $title = $request->title;
        $author_id = $request->author_id;
        $year_published = $request->year_published;
        $category_id = $request->category_id;
        $category = $request->category;
        $comment = $request->comment;

        return $this->bookService->findBooks($book_id, $title, $author_id, $year_published, $category_id, $category, $comment);
    }
}
