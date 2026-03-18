<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function register(array $data): array
    {
        $user = $this->userRepository->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'], // hashé automatiquement via cast
            'role'     => $data['role'],
        ]);

        $token = auth()->login($user);

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials): array
    {
        $token = auth()->attempt([
            'email'    => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        if (!$token) {
            throw new \Exception('Email ou mot de passe incorrect.', 401);
        }

        return [
            'user'  => auth()->user(),
            'token' => $token,
        ];
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function resetPassword(array $data): string
    {
        $status = Password::sendResetLink(['email' => $data['email']]);

        if ($status !== Password::RESET_LINK_SENT) {
            throw new \Exception('Impossible d\'envoyer le lien de réinitialisation.', 400);
        }

        return $status;
    }
}