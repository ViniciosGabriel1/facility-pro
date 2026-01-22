<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriarDentistaRequest;
use App\Http\Requests\AtualizarDentistaRequest;
use App\Services\DentistaService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class DentistasController extends Controller
{
    public function __construct(
        private readonly DentistaService $service
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

    public function store(CriarDentistaRequest $request): JsonResponse
    {

        // dd(auth()->user());


        return ApiResponse::success(
            $this->service->store(
                $request->validated()
            ),
            'Dentista cadastrado com sucesso.',
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
        AtualizarDentistaRequest $request,
        string $id
    ): JsonResponse {
        return ApiResponse::success(
            $this->service->update($id, $request->validated()),
            'Dentista atualizado com sucesso.'
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->service->delete($id);

        return ApiResponse::success(
            null,
            'Dentista removido com sucesso.'
        );
    }
}
