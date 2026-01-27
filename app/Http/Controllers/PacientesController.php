<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriarPacienteRequest;
use App\Http\Requests\AtualizarPacienteRequest;
use App\Services\PacienteService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class PacientesController extends Controller
{
    public function __construct(
        private readonly PacienteService $service
    ) {}

    public function index(): JsonResponse
    {
        $items = $this->service->index();

        return ApiResponse::success(
            $items->items(),
            'Pacientes listados com sucesso!',
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

    public function store(CriarPacienteRequest $request): JsonResponse
    {
        return ApiResponse::success(
            $this->service->store($request->validated()),
            'Paciente cadastrado com sucesso.',
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
        AtualizarPacienteRequest $request,
        string $id
    ): JsonResponse {
        return ApiResponse::success(
            $this->service->update($id, $request->validated()),
            'Paciente atualizado com sucesso.'
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->service->delete($id);

        return ApiResponse::success(
            null,
            'Paciente removido com sucesso.'
        );
    }
}
