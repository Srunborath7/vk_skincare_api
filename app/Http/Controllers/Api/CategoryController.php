<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ApiResponseTrait;
    public function index()
    {
        $category = Category::with('user')->get();

        return $this->successApiResponse($category->load('user'),"Get all categories successfully!",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validated();
        $validated['creator'] = $user->id;

        $category = Category::create($validated);

        return $this->successApiResponse($category->load('user'),"Created category successfully!",201);
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
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $user = $request->user();
        $category = Category::find($id);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if(!$category){
            return $this->errorApiResponse("Category not found!",404);
        }
        $validated = $request->validated();
        $validated['creator'] = $user->id;

        $category -> update($validated);

        return $this->successApiResponse($category->load('user'),"Updated category successfully!",201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , string $id)
    {
        $user = $request->user();
        $category = Category::find($id);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if(!$category){
            return $this->errorApiResponse("Category not found!",404);
        }
        $category -> delete($id);
         return $this->successApiResponse("Deleted category successfully!",201);
    }
}
