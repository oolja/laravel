<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\RestaurantFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreRestaurantRequest;
use App\Http\Requests\V1\UpdateRestaurantRequest;
use App\Http\Resources\V1\RestaurantCollection;
use App\Http\Resources\V1\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class RestaurantController extends Controller
{
    private const PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     * @param RestaurantFilter $filter
     * @return RestaurantCollection
     */
    public function index(RestaurantFilter $filter): RestaurantCollection
    {
        $restaurants = Restaurant::where($filter->transform())
            ->with($filter->include());

        return new RestaurantCollection(
            $restaurants->paginate(self::PER_PAGE)
                ->appends($filter->request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRestaurantRequest $request
     * @return RestaurantResource
     */
    public function store(StoreRestaurantRequest $request): RestaurantResource
    {
        return new RestaurantResource(Restaurant::create($request->all()));
    }

    /**
     * Display the specified resource.
     * @param RestaurantFilter $filter
     * @param Restaurant $restaurant
     * @return RestaurantResource
     */
    public function show(RestaurantFilter $filter, Restaurant $restaurant): RestaurantResource
    {
        return new RestaurantResource($restaurant->loadMissing($filter->include()));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRestaurantRequest $request
     * @param Restaurant $restaurant
     * @return RestaurantResource
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant): RestaurantResource
    {
        $restaurant->update($request->all());

        return new RestaurantResource($restaurant);
    }

    /**
     * Remove the specified resource from storage.
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function destroy(Restaurant $restaurant): JsonResponse
    {
        $restaurant->delete();
        return response()->json(null, 204);
    }
}
