<?php

namespace App\Http\Controllers\Api;

use Exception;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;

class CategoryApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected CategoryService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request):JsonResponse
    {
        try {

            $data = $this->service->list($request);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

        return $this->successResponse($data, 'Listagem gerada com sucesso!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {

            $dataDTO = CategoryDTO::fromArray($request->validated());
            $this->service->create($dataDTO);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

        return $this->successResponse([], 'Categoria criada com sucesso!', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        try {

            $category = $this->service->show($category);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

        return $this->successResponse($category->toArray(), 'Operação realizada com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category): JsonResponse
    {
        try {
            
            $data = CategoryDTO::fromArray($request->validated());
            $category = $this->service->update($data, $category);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

        return $this->successResponse([], 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            
            $this->service->delete($category);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

        return $this->successResponse([], 'Categoria excluida com sucesso!', 200);
    }

    public function getAllList(): JsonResponse
    {
        try {

            $data = $this->service->getListAll();

            return $this->successResponse($data, 'Listagem gerada com sucesso!');

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}