<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private const PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     */
    public function index(UserFilter $filter): UserCollection
    {
        $users = User::where($filter->transform())
            ->with($filter->include());

        $users = $filter->sort($users);

        return new UserCollection(
            $users->paginate(self::PER_PAGE)
                ->appends($filter->request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): UserResource
    {
        return new UserResource(User::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(UserFilter $filter, User $user): UserResource
    {
        return new UserResource($user->loadMissing($filter->include()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $user->update($request->all());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
