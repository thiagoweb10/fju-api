<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Retorna resposta de sucesso padronizada
     *
     * @param mixed $data Conteúdo de dados (array ou objeto)
     * @param string|null $message Mensagem de sucesso
     * @param int $statusCode Código HTTP
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    protected function successResponse($aData = [], string $message = 'Success', int $statusCode = 200 )
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $aData
        ], $statusCode, [],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Retorna resposta de erro padronizada
     *
     * @param string $message Mensagem de erro
     * @param int $statusCode Código HTTP
     * @param mixed $errors Detalhes adicionais (validação etc.)
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message = 'Error', int $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $statusCode, [], JSON_UNESCAPED_UNICODE);
    }
}