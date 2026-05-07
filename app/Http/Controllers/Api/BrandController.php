<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Traits\ApiResponseTrait;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ApiResponseTrait;
    public function index()
    {
        $brands = Brand::with('product', 'user')->get();
        return $this->successApiResponse($brands->load('product', 'user'), "Get all brands successfully!", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBrandRequest $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->errorApiResponse("Unauthorized! please login account.", 401);
        }

        $validated = $request->validated();
        $validated["creator"] = $user->id;

        if ($request->hasFile("logo")) {

            $upload = Cloudinary::uploadApi()->upload(
                $request->file("logo")->getRealPath(),
                ["folder" => "vk_skincare/brands"]
            );

            $validated["logo_url"] = $upload['secure_url'];
            $validated["logo_public_id"] = $upload['public_id'];
        }

        $brand = Brand::create($validated);

        return $this->successApiResponse(
            $brand,
            "Create brand successfully!",
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $user = $request->user();

        if (!$user) {
            return $this->errorApiResponse("Unauthorized! please login account.", 401);
        }

        $brand = Brand::find($id, ['*']);
        if (!$brand) {
            return $this->errorApiResponse("Brand not found!", 404);
        }

        // validate first
        $validated = $request->validated();
        $validated['creator'] = $user->id;

        // If new logo uploaded
        if ($request->hasFile("logo")) {

            // delete old image
            if ($brand->logo_public_id) {
                Cloudinary::uploadApi()->destroy($brand->logo_public_id);
            }

            // upload new image
            $upload = Cloudinary::uploadApi()->upload(
                $request->file("logo")->getRealPath(),
                ["folder" => "vk_skincare/brands"]
            );

            $validated["logo_url"] = $upload['secure_url'];
            $validated["logo_public_id"] = $upload['public_id'];
        }

        $brand->update($validated);

        return $this->successApiResponse($brand, "Updated brand successfully!", 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user) {
            return $this->errorApiResponse("Unauthorized! please login account.", 401);
        }

        $brand = Brand::find($id, ['*']);
        if (!$brand) {
            return $this->errorApiResponse("Brand not found!", 404);
        }

        if (!empty($brand->logo_public_id)) {
            Cloudinary::uploadApi()->destroy($brand->logo_public_id);
        }
        $brand->delete();

        return $this->successApiResponse(null, "Delete brand successfully!", 200);
    }
}
