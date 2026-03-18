<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     tags={"Auth"},
     *     summary="Inscription d'un utilisateur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation","role"},
     *             @OA\Property(property="name", type="string", example="Alice"),
     *             @OA\Property(property="email", type="string", example="alice@test.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", example="password123"),
     *             @OA\Property(property="role", type="string", enum={"student","teacher"})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Inscription réussie"),
     *     @OA\Response(response=422, description="Validation échouée")
     * )
     */
    public function register(Request $request): JsonResponse{
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'=> 'required|in:student,teacher',
        ]);

        $result = $this->authService->register($validated);

        return response()->json([
            'message' => 'Inscription réussie.',
            'user'=> $result['user'],
            'token'=> $result['token'],
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Auth"},
     *     summary="Connexion",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="alice@test.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Connexion réussie"),
     *     @OA\Response(response=401, description="Identifiants incorrects")
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'=> 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $result = $this->authService->login($validated);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'message' => 'Connexion réussie.',
            'user'=> $result['user'],
            'token'=> $result['token'],
        ]);
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"Auth"},
     *     summary="Déconnexion",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Déconnexion réussie")
     * )
     */
    public function logout(): JsonResponse{
        $this->authService->logout();
        return response()->json(['message' => 'Déconnexion réussie.']);
    }

    /**
     * @OA\Post(
     *     path="/auth/reset-password",
     *     tags={"Auth"},
     *     summary="Réinitialisation du mot de passe",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", example="alice@test.com")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Lien envoyé"),
     *     @OA\Response(response=422, description="Email invalide")
     * )
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' =>'required|email|exists:users,email',
        ]);

        try {
            $this->authService->resetPassword($request->only('email'));
        } catch (\Exception $e) {
            return response()->json(['message'=> $e->getMessage()], $e->getCode());
        }
        return response()->json(['message'=> 'Lien de réinitialisation envoyé.']);
    }
}