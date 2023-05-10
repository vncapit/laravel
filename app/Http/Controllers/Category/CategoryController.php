<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Modules\Category\ErrorCode\CategoryErrorCode;
use App\Modules\Category\Service\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function createCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        $category = new Category();
        $category->name = $request->name;

        $res = $this->categoryService->createCategory($category);
        if ($res !== CategoryErrorCode::CATEGORY_CREATE_FAILED) {
            return $this->success(1);
        }
        return $this->failed($res, CategoryErrorCode::getText($res));
    }

    public function deleteCategory(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:categories,id'
        ]);

        return $this->categoryService->deleteCategory($request->id);
    }
}
