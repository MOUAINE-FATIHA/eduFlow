<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(
        private WishlistService $wishlistService
    ) {}

    /**
     * @OA\Get(
     *     path="/student/wishlist",
     *     tags={"Wishlist"},
     *     summary="Ma liste de cours sauvegardés",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Wishlist de l'étudiant")
     * )
     */
    public function index(): JsonResponse{
        $wishlist = $this->wishlistService->getWishlist(auth()->id());
        return response()->json(['data' => $wishlist]);
    }

    /**
     * @OA\Post(
     *     path="/student/wishlist",
     *     tags={"Wishlist"},
     *     summary="Ajouter un cours à la wishlist",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"course_id"},
     *             @OA\Property(property="course_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Cours ajouté à la wishlist"),
     *     @OA\Response(response=409, description="Déjà dans la wishlist")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
        ]);

        try {
            $item = $this->wishlistService->addToWishlist(
                auth()->id(),
                $validated['course_id']
            );
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'message' => 'Cours ajouté à la wishlist.',
            'data'    => $item,
        ], 201);
    }

    /**
     * @OA\Delete(
     *     path="/student/wishlist/{courseId}",
     *     tags={"Wishlist"},
     *     summary="Retirer un cours de la wishlist",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="courseId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Cours retiré"),
     *     @OA\Response(response=404, description="Cours non trouvé dans la wishlist")
     * )
     */
    public function destroy(int $courseId): JsonResponse
    {
        try {
            $this->wishlistService->removeFromWishlist(auth()->id(), $courseId);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Cours retiré de la wishlist.']);
    }
}