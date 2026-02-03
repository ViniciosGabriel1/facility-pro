<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriarConsultaRequest;
use App\Http\Requests\AtualizarConsultaRequest;
use App\Services\ConsultaService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class ConsultasController extends Controller
{
    public function __construct(
        private readonly ConsultaService $service
    ) {}

    public function index(): JsonResponse
    {
        $items = $this->service->index();

        return ApiResponse::success(
            $items->items(),
            null,
            200,
            [
                'pagination' => [
                    'current_page' => $items->currentPage(),
                    'per_page'     => $items->perPage(),
                    'last_page'    => $items->lastPage(),
                    'total'        => $items->total(),
                    'has_next'     => $items->hasMorePages(),
                    'has_prev'     => $items->currentPage() > 1,
                ],
            ]
        );
    }

    public function store(CriarConsultaRequest $request): JsonResponse
    {

        // dd($request->validated());
        return ApiResponse::success(
            $this->service->store($request->validated()),
            'Consulta cadastrado com sucesso.',
            201
        );
    }

    // public function show(string $id): JsonResponse
    // {
    //     return ApiResponse::success(
    //         $this->service->show($id)
    //     );
    // }

    public function update(
        AtualizarConsultaRequest $request,
        string $id
    ): JsonResponse {
        return ApiResponse::success(
            $this->service->update($id, $request->validated()),
            'Consulta atualizado com sucesso.'
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->service->delete($id);

        return ApiResponse::success(
            null,
            'Consulta removido com sucesso.'
        );
    }
}
