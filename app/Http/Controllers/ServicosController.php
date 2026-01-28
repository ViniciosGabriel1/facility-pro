<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriarServicoRequest;
use App\Http\Requests\AtualizarServicoRequest;
use App\Services\ServicoService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class ServicosController extends Controller
{
    public function __construct(
        private readonly ServicoService $service
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

    public function store(CriarServicoRequest $request): JsonResponse
    {
        return ApiResponse::success(
            $this->service->store($request->validated()),
            'Servico cadastrado com sucesso.',
            201
        );
    }

    public function show(string $id): JsonResponse
    {
        return ApiResponse::success(
            $this->service->show($id)
        );
    }

    public function update(
        AtualizarServicoRequest $request,
        string $id
    ): JsonResponse {
        return ApiResponse::success(
            $this->service->update($id, $request->validated()),
            'Servico atualizado com sucesso.'
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->service->delete($id);

        return ApiResponse::success(
            null,
            'Servico removido com sucesso.'
        );
    }
}
