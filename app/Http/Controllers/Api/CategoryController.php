<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    use ApiResponse;

    public function __construct(private CategoryServiceInterface $categoryService) {}

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAll();

        return $this->successResponse(
            CategoryResource::collection($categories),
            'Categories retrieved successfully.'
        );
    }

    public function show(int $id): JsonResponse
    {
        $category = $this->categoryService->getById($id);

        return $category
            ? $this->successResponse(
                new CategoryResource($category),
                'Category retrieved successfully.'
            )
            : $this->errorResponse('Category not found.', 404);
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $category = $this->categoryService->create($request->validated());

        return $this->successResponse(
            new CategoryResource($category),
            'Category created successfully.',
            201
        );
    }

    public function update(CategoryUpdateRequest $request, int $id): JsonResponse
    {
        $updated = $this->categoryService->update($id, $request->validated());

        return $updated
            ? $this->successResponse(
                new CategoryResource($this->categoryService->getById($id)),
                'Category updated successfully.'
            )
            : $this->errorResponse('Category not found.', 404);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->categoryService->delete($id)
            ? $this->successResponse(null, 'Category deleted successfully.')
            : $this->errorResponse('Category not found.', 404);
    }
}