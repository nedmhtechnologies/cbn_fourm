<?php

namespace TeamTeaTime\Forum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use TeamTeaTime\Forum\Http\Requests\CreateCategory;
use TeamTeaTime\Forum\Http\Requests\DeleteCategory;
use TeamTeaTime\Forum\Http\Requests\UpdateCategory;
use TeamTeaTime\Forum\Http\Resources\CategoryResource;
use TeamTeaTime\Forum\Models\Category;
use TeamTeaTime\Forum\Support\CategoryPrivacy;

class CategoryController extends BaseController
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $categories = CategoryPrivacy::getFilteredFor($request->user, $request->query('parent_id'))->keys();

        return CategoryResource::collection($categories);
    }

    public function fetch(Request $request, Category $category): CategoryResource
    {
        if (! $category->isAccessibleTo($request->user())) {
            return $this->notFoundResponse();
        }

        return new CategoryResource($category);
    }

    public function store(CreateCategory $request): CategoryResource
    {
        $category = $request->fulfill();

        return new CategoryResource($category);
    }

    public function update(UpdateCategory $request): CategoryResource
    {
        $category = $request->fulfill();

        return new CategoryResource($category);
    }

    public function delete(DeleteCategory $request): Response
    {
        $request->fulfill();

        return new Response(['success' => true], 200);
    }
}
