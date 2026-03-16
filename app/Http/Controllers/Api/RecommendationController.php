<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RecommendationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function __construct(
        private RecommendationService $recommendationService
    ) {}

    /**
     * @OA\Get(
     *     path="/student/recommendations",
     *     tags={"Recommendations"},
     *     summary="Cours recommandés selon les intérêts de l'étudiant",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Liste des cours recommandés")
     * )
     */
    public function index(): JsonResponse
    {
        $courses = $this->recommendationService->getRecommendedCourses();

        return response()->json(['data' => $courses]);
    }

    /**
     * @OA\Post(
     *     path="/student/interests",
     *     tags={"Recommendations"},
     *     summary="Mettre à jour les intérêts de l'étudiant",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="interest_ids",
     *                 type="array",
     *                 @OA\Items(type="integer"),
     *                 example={1, 2, 3}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Intérêts mis à jour")
     * )
     */
    public function updateInterests(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'interest_ids'   => 'required|array',
            'interest_ids.*' => 'integer|exists:interests,id',
        ]);

        $this->recommendationService->syncUserInterests($validated['interest_ids']);

        return response()->json(['message' => 'Intérêts mis à jour avec succès.']);
    }
}