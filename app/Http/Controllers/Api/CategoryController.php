<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Interfaces\Services\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    public function index(): JsonResponse
    {
        return response()->json(CategoryResource::collection($this->categoryService->getAll()));
    }

    public function show(int $id): JsonResponse
    {
        $category = $this->categoryService->getById($id);
        return $category
            ? response()->json(new CategoryResource($category))
            : response()->json(['message' => 'Category not found'], 404);
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $category = $this->categoryService->create($request->validated());
        return response()->json(new CategoryResource($category), 201);
    }

    public function update(CategoryUpdateRequest $request, int $id): JsonResponse
    {
        $updated = $this->categoryService->update($id, $request->validated());
        return $updated
            ? response()->json(new CategoryResource($this->categoryService->getById($id)))
            : response()->json(['message' => 'Category not found'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->categoryService->delete($id)
            ? response()->json(['message' => 'Category deleted'])
            : response()->json(['message' => 'Category not found'], 404);
    }
}