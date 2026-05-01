<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductDetailRequest;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Traits\ApiResponseTrait;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ApiResponseTrait;
    public function index()
    {
        $productDetails = ProductDetail::with(['product','user'])->get();  
        return $this->successApiResponse($productDetails, "Get all product details successfully!", 200);
    }
    /**
     * Store a newly created resource in storage.
     */
public function store(CreateProductDetailRequest $request)
{
    $user = $request->user();
    if (!$user) {
        return $this->errorApiResponse('Unauthorized', 401);
    }

    $validated = $request->validated();

    $product = Product::findOrFail($request->input('product_id'));

    if (!$product) {
        return $this->errorApiResponse('Product not found', 404);
    }

    $folderName = "vk_skincare/products/" .
        strtolower(str_replace(' ', '_', $product->name));

    $imageUrls = [];
    $imagePublicIds = [];

    if ($request->hasFile('image_details')) {
        foreach ($request->file('image_details') as $image) {

            $upload = Cloudinary::uploadApi()->upload(
                $image->getRealPath(),
                ["folder" => $folderName]
            );

            $imageUrls[] = $upload['secure_url'];
            $imagePublicIds[] = $upload['public_id'];
        }
    }

    $validated['image_details'] = $imageUrls;
    $validated['image_details_public_ids'] = $imagePublicIds;
    $validated['creator'] = $user->id;

    $productDetail = ProductDetail::create($validated);

    return $this->successApiResponse(
        $productDetail,
        "Product detail created successfully!",
        201
    );
}

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $user = $request->user();
        if (!$user) {
            return $this->errorApiResponse('Unauthorized', 401);
        }
        $productDetail = ProductDetail::with(['product','user'])->findOrFail($id);
        return $this->successApiResponse($productDetail, "Get product detail successfully!", 200);
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
