<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\RestaurantFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreRestaurantRequest;
use App\Http\Resources\V1\RestaurantCollection;
use App\Http\Resources\V1\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    private const PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return RestaurantCollection
     */
    public function index(Request $request): RestaurantCollection
    {
        //TODO Create user facade or inject via service container.
        $filter = new RestaurantFilter();
        $query = $filter->transform($request);

        if (!empty($query)) {
            return new RestaurantCollection(
                Restaurant::where($query)
                    ->paginate(self::PER_PAGE)
                    ->appends($request->query())
            );
        }

        return new RestaurantCollection(Restaurant::paginate(self::PER_PAGE));
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
     * @param Restaurant $restaurant
     * @return RestaurantResource
     */
    public function show(Restaurant $restaurant): RestaurantResource
    {
        return new RestaurantResource($restaurant);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreRestaurantRequest $request
     * @param Restaurant $restaurant
     * @return RestaurantResource
     */
    public function update(StoreRestaurantRequest $request, Restaurant $restaurant): RestaurantResource
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
