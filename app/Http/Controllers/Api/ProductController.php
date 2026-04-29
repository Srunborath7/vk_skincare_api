<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
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
        $product = Product::with("user")->get();
        return $this->successApiResponse($product,"Get all products successfully!",200);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
