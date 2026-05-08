<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSlideBannersRequest;
use App\Http\Requests\UpdateSlideBannersRequest;
use App\Models\SlideBanners;
use App\Traits\ApiResponseTrait;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class SlideBannersController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = SlideBanners::with("user")->get();
        return $this->successApiResponse($banners->load("user"), "Get all slide banners successfully!", 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSlideBannersRequest $request)
    {
        $user = $request->user();
        if(!$user){
            return $this->errorApiResponse("Unauthorized", 401);
        }
        $validated = $request->validated();
        $validated["creator"] = $user->id;
        if ($request->hasFile("banner_image")) {

            $upload = Cloudinary::uploadApi()->upload(
                $request->file("banner_image")->getRealPath(),
                ["folder" => "vk_skincare/banners"]
            );

            $validated["banner_image_url"] = $upload['secure_url'];
            $validated["banner_image_public_id"] = $upload['public_id'];
        }
        $banner = SlideBanners::create($validated);
        return $this->successApiResponse($banner, "Create slide banner successfully!", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = SlideBanners::with("user")->find($id, ["*"]);
        if(!$banner){
            return $this->errorApiResponse("Banner not found", 404);
        }
        return $this->successApiResponse($banner->load("user"), "Get slide banner successfully!", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSlideBannersRequest $request, string $id)
    {
        $user = $request->user();
        if(!$user){
            return $this->errorApiResponse("Unauthorized", 401);
        }
        $banner = SlideBanners::find($id, ["*"]);
        if(!$banner){
            return $this->errorApiResponse("Banner not found", 404);
        }
        $validated = $request->validated();
        if ($request->hasFile("banner_image")) {
            if ($banner->banner_image_public_id) {
                Cloudinary::uploadApi()->destroy($banner->banner_image_public_id);
            }

            $upload = Cloudinary::uploadApi()->upload(
                $request->file("banner_image")->getRealPath(),
                ["folder" => "vk_skincare/banners"]
            );

            $validated["banner_image_url"] = $upload['secure_url'];
            $validated["banner_image_public_id"] = $upload['public_id'];
        }
        $banner->update($validated);
        return $this->successApiResponse($banner, "Update slide banner successfully!", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = SlideBanners::find($id, ["*"]);
        if(!$banner){
            return $this->errorApiResponse("Banner not found", 404);
        }
        if ($banner->banner_image_public_id) {
            Cloudinary::uploadApi()->destroy($banner->banner_image_public_id);
        }
        $banner->delete();
        return $this->successApiResponse(null, "Delete slide banner successfully!", 200);
    }
}
