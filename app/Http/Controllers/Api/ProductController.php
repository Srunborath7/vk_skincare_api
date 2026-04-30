<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with(["user","category","brand","productDetail"])->get();
        return $this->successApiResponse($product->load(["user","category","brand","productDetail"]),"Get all products successfully!",200);
    }
    public function getTags()
    {
        $tags = Product::pluck('tags', 'id')
            ->flatten()
            ->map(fn($tag) => strtolower(trim($tag)))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return $this->successApiResponse(
            $tags,
            "Get all product tags successfully!",
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validated = $request->validated();
        $validated["creator"] = $user->id;

        if ($request->hasFile("image")) {

            $upload = Cloudinary::uploadApi()->upload(
                $request->file("image")->getRealPath(),
                ["folder" => "vk_skincare/products"]
            );

            $validated["image_url"] = $upload['secure_url'];
            $validated["image_public_id"] = $upload['public_id'];
        }
        $product = Product::create($validated);

        return $this->successApiResponse($product,"Created Product successfully!",200);

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
    public function update(UpdateProductRequest $request, string $id)
    {
        $user = $request->user();
        $product = Product::find($id, ['*']);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $validated = $request->validated();
        $validated["creator"] = $user->id;
        if ($request->hasFile("image")) {
            if ($product->image_public_id) {
                Cloudinary::uploadApi()->destroy($product->image_public_id);
            }

            $upload = Cloudinary::uploadApi()->upload(
                $request->file("image")->getRealPath(),
                ["folder" => "vk_skincare/products"]
            );

            $validated["image_url"] = $upload['secure_url'];
            $validated["image_public_id"] = $upload['public_id'];
        }
        $product->update($validated);
        return $this->successApiResponse($product, "Product updated successfully!", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id, ['*']);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        if ($product->image_public_id) {
            Cloudinary::uploadApi()->destroy($product->image_public_id);
        }
        $product->delete();
        return $this->successApiResponse("Deleted product successfully!", 200);
    }
}
