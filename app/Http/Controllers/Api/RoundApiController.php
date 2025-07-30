<?php

namespace App\Http\Controllers\Api;

use App\DTOs\RoundDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Round\StoreRequest;
use App\Http\Requests\Round\UpdateRequest;
use App\Models\Round;
use App\Services\RoundService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoundApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected RoundService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->service->list($request->only(['name']));

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
            $dataDTO = RoundDTO::fromRequest($request);

            $this->service->create($dataDTO);

            return $this->successResponse([], 'Rodada criada com sucesso!', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Round $round): JsonResponse
    {
        try {
            $round = $this->service->show($round);

            return $this->successResponse($round->toArray(), 'Operação realizada com sucesso!');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Round $round): JsonResponse
    {
        try {
            $data = RoundDTO::fromArray($request->validated());

            $round = $this->service->update($data, $round);

            return $this->successResponse([], 'Registro atualizado com sucesso!');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Round $round): JsonResponse
    {
        try {
            $this->service->delete($round);

            return $this->successResponse([], 'Roda excluida com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
