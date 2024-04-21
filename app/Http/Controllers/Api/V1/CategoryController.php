<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CategoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCategoryRequest;
use App\Http\Requests\V1\UpdateCategoryRequest;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    private const PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     */
    public function index(CategoryFilter $filter): CategoryCollection
    {
        $categories = Category::where($filter->transform())
            // TODO: Implement 'withWhereHas' method or find way to filter related columns
//            ->whereHas('items', function ($query) use ($filter) {
//                $query->where($filter->transformItems());
//            })
            ->with($filter->include());

        $categories = $filter->sort($categories);

        return new CategoryCollection(
            $categories->paginate(self::PER_PAGE)
                ->appends($filter->request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        return new CategoryResource(Category::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryFilter $filter, Category $category): CategoryResource
    {
        return new CategoryResource($category->loadMissing($filter->include()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $category->update($request->all());

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
