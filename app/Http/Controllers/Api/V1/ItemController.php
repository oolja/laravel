<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ItemFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreItemRequest;
use App\Http\Requests\V1\UpdateItemRequest;
use App\Http\Resources\V1\ItemCollection;
use App\Http\Resources\V1\ItemResource;
use App\Models\Item;
use Illuminate\Http\JsonResponse;

class ItemController extends Controller
{
    private const PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     */
    public function index(ItemFilter $filter): ItemCollection
    {
        $items = Item::where($filter->transform())
//            ->whereHas('categories', function ($query) use ($filter) {
//                $query->where($filter->transformCategories());
//            })
            ->with($filter->include());

        $items = $filter->sort($items);

        return new ItemCollection(
            $items->paginate(self::PER_PAGE)
                ->appends($filter->request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request): ItemResource
    {
        $item = Item::create($request->all());

        if ($request->has('categories')) {
            $item->categories()->attach($request->get('categories'));
        }

        return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemFilter $filter, Item $item): ItemResource
    {
        return new ItemResource($item->loadMissing($filter->include()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item): ItemResource
    {
        $item->update($request->all());

        if ($request->has('categories')) {
            $categories = is_array($request->get('categories')) ? $request->get('categories') : [];
            $item->categories()->sync($categories);
        }

        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item): JsonResponse
    {
        $item->delete();

        return response()->json(null, 204);
    }
}
