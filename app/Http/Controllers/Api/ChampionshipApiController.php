<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ChampionshipDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Championship\StoreRequest;
use App\Http\Requests\Championship\UpdateRequest;
use App\Models\Championship;
use App\Services\ChampionshipService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChampionshipApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected ChampionshipService $service
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
            $dataDTO = ChampionshipDTO::fromRequest($request);

            $this->service->create($dataDTO);

            return $this->successResponse([], 'Campeonato criado com sucesso!', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Championship $championship): JsonResponse
    {
        try {
            $championship = $this->service->show($championship);

            return $this->successResponse($championship->toArray(), 'Operação realizada com sucesso!');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Championship $championship): JsonResponse
    {
        try {
            $dataDTO = ChampionshipDTO::fromRequest($request);

            $championship = $this->service->update($dataDTO, $championship);

            return $this->successResponse([], 'Registro atualizado com sucesso!');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Championship $championship): JsonResponse
    {
        try {
            $this->service->delete($championship);

            return $this->successResponse([], 'Campeonato excluido com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
