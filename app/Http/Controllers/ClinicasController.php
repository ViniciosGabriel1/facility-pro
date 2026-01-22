<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarClinicaRequest;
use App\Http\Requests\CriarClinicaRequest;
use App\Services\ClinicasService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClinicasController extends Controller
{

    // private $clinicaService;

    public function __construct(private readonly ClinicasService $clinicaService)
    {
        // $this->clinicaService = $clinicaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $clinicas = $this->clinicaService->index();

        return ApiResponse::success(
            $clinicas->items(), // apenas os registros
            null,
            200,
            [
                'pagination' => [
                    'current_page' => $clinicas->currentPage(),
                    'per_page'     => $clinicas->perPage(),
                    'last_page'    => $clinicas->lastPage(),
                    'total'        => $clinicas->total(),
                    'has_next'     => $clinicas->hasMorePages(),
                    'has_prev'     => $clinicas->currentPage() > 1,
                ],
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarClinicaRequest $request): JsonResponse
    {
        $clinica = $this->clinicaService->store($request->validated());

        return ApiResponse::success(
            $clinica, // apenas os registros
            'Clínica cadsatrada com sucesso!',
            200,
            []
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(AtualizarClinicaRequest $request, string $id): JsonResponse
    {
        $clinica = $this->clinicaService->update(
            $id,
            $request->validated()
        );

        return ApiResponse::success(
            $clinica,
            'Clínica atualizada com sucesso.',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->clinicaService->delete($id);

        return ApiResponse::success(
            null,
            'Clínica removida com sucesso.',
            200
        );
    }
}
