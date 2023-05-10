<?php


namespace App\Modules\Category\Service;


use App\Models\Category;
use App\Modules\Category\ErrorCode\CategoryErrorCode;

class CategoryService
{
    public function __construct()
    {

    }

    public function createCategory(Category $category)
    {
        $checkBook = Category::whereName($category->name)->first();
        if ($checkBook){
            return CategoryErrorCode::CATEGORY_CREATE_FAILED;
        }
        return $category->save();
    }

    public function deleteCategory($id)
    {
        return Category::destroy($id);
    }
}
