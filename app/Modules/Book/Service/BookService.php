<?php


namespace App\Modules\Book\Service;


use App\Models\Book;
use App\Models\Category;
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

    public function findBooks($book_id, $title, $author_id, $year_published, $category_id, $category, $comment)
    {
        $select = Book::with(['user', 'categories', 'comments'])->select();


        if ($book_id) {
            $select->where('id', $book_id);
        }

        if ($title) {
            $select->where('title', 'like', '%'.$title.'%');
        }

        if ($author_id) {
            $select->whereHas('user', function ($query) use ($author_id) {
                $query->whereId($author_id);
            });
        }

        if ($year_published) {
            $select->whereYearPublished($year_published);
        }

        if ($category_id) {
            $select->whereHas('categories', function($query) use($category_id) {
                $query->where('categories.id', $category_id);
            });
        }

        if ($category) {
            $select->whereHas('categories', function($query) use($category) {
                $query->where('name', 'like', '%'.$category.'%');
            });
        }

        if ($comment) {
            $select->whereHas('comments', function($query) use ($comment) {
                $query->where('content', 'like', '%'.$comment.'%');
            });
        }

        return $select->paginate(request()['limit']);
    }
}
