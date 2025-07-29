<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected CategoryService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->service->list($request->only(['description']));

            return $this->successResponse($data, 'Listagem gerada com sucesso!');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $dataDTO = CategoryDTO::fromArray($request->validated());

            $this->service->create($dataDTO);

            return $this->successResponse([], 'Categoria criada com sucesso!', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        try {
            $category = $this->service->show($category);

            return $this->successResponse($category->toArray(), 'Operação realizada com sucesso!');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category): JsonResponse
    {
        try {
            $data = CategoryDTO::fromArray($request->validated());

            $category = $this->service->update($data, $category);

            return $this->successResponse([], 'Registro atualizado com sucesso!');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $this->service->delete($category);

            return $this->successResponse([], 'Categoria excluida com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
