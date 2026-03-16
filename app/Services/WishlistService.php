<?php

namespace App\Services;

use App\Models\Wishlist;
use App\Repositories\Interfaces\WishlistRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WishlistService
{
    public function __construct(
        private WishlistRepositoryInterface $wishlistRepository
    ) {}

    public function getWishlist(int $studentId): Collection
    {
        return $this->wishlistRepository->getByStudent($studentId);
    }

    public function addToWishlist(int $studentId, int $courseId): Wishlist
    {
        if ($this->wishlistRepository->exists($studentId, $courseId)) {
            throw new \Exception('Ce cours est déjà dans votre wishlist.', 409);
        }

        return $this->wishlistRepository->add($studentId, $courseId);
    }

    public function removeFromWishlist(int $studentId, int $courseId): bool
    {
        if (!$this->wishlistRepository->exists($studentId, $courseId)) {
            throw new \Exception('Ce cours n\'est pas dans votre wishlist.', 404);
        }

        return $this->wishlistRepository->remove($studentId, $courseId);
    }
}