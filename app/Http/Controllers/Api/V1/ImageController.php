<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ImageFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreImageRequest;
use App\Http\Requests\V1\UpdateImageRequest;
use App\Http\Resources\V1\ImageCollection;
use App\Http\Resources\V1\ImageResource;
use App\Models\Image;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Storage;

class ImageController extends Controller
{
    private const PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     */
    public function index(ImageFilter $filter): ImageCollection
    {
        $images = Image::where($filter->transform())
            ->with($filter->include());

        $images = $filter->sort($images);

        return new ImageCollection(
            $images->paginate(self::PER_PAGE)
                ->appends($filter->request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreImageRequest $request
     * @return ImageResource
     */
    public function store(StoreImageRequest $request): ImageResource
    {
        /** @var  UploadedFile $file */
        $file = $request->file('image');

        return new ImageResource(Image::create([
            'image' => $file->store('public'),
            'description' => $request->get('description', null),
        ]));
    }

    /**
     * Display the specified resource.
     * @param ImageFilter $filter
     * @param Image $image
     * @return ImageResource
     */
    public function show(ImageFilter $filter, Image $image): ImageResource
    {
        return new ImageResource($image->loadMissing($filter->include()));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateImageRequest $request
     * @param Image $image
     * @return ImageResource
     */
    public function update(UpdateImageRequest $request, Image $image): ImageResource
    {
        $image->update($request->all());

        return new ImageResource($image);
    }

    /**
     * Remove the specified resource from storage.
     * @param Image $image
     * @return JsonResponse
     */
    public function destroy(Image $image): JsonResponse
    {

        $file = public_path(Storage::url($image->image));

        if(File::exists($file)){
            File::delete($file);
            $image->delete();
            return response()->json(null, 204);
        } else {
            abort(404);
        }
    }
}
