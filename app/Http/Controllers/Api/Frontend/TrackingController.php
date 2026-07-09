<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\TrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TrackingController extends Controller
{
    public function __construct(
        private readonly TrackingService $trackingService
    ) {}

    /**
     * GET /api/frontend/tracking?code={guia}&document={dni}
     */
    public function show(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|max:64',
                'document' => 'required|string|regex:/^\d{8,11}$/',
            ], [
                'code.required' => 'Código de guía y documento son obligatorios.',
                'document.required' => 'Código de guía y documento son obligatorios.',
                'document.regex' => 'Código de guía y documento son obligatorios.',
            ]);
        } catch (ValidationException) {
            return response()->json(['message' => 'Código de guía y documento son obligatorios.'], 400);
        }

        $payload = $this->trackingService->findByCodeAndDocument(
            $validated['code'],
            $validated['document']
        );

        if ($payload === null) {
            return response()->json(['message' => 'Encomienda no encontrada.'], 404);
        }

        return response()->json($payload);
    }
}
