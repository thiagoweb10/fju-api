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
use App\Exceptions\CategoryNotFoundException;
use App\Http\Requests\Category\UpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

            $data = $this->service->list($request->only(['description']));

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

            return $this->successResponse([], 'Categoria criada com sucesso!', 201);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $categoryId): JsonResponse
    {
        try {

            $category = Category::findOrFail($categoryId);

            $category = $this->service->show($category);

            return $this->successResponse($category->toArray(), 'Operação realizada com sucesso!');
        
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException("Categoria não encontrada.", 404);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, int $category): JsonResponse
    {
        try {

            $category = Category::findOrFail($category);

            $data = CategoryDTO::fromArray($request->validated());

            $category = $this->service->update($data, $category);

            return $this->successResponse([], 'Registro atualizado com sucesso!');

        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException("Categoria não encontrada.", 404);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $category): JsonResponse
    {
        try {

            $category = Category::findOrFail($category);
            
            $this->service->delete($category);

            return $this->successResponse([], 'Categoria excluida com sucesso!', 200);
        
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException("A categoria que você tentou excluir não existe.", 404);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}