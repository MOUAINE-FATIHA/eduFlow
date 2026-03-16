<?php

namespace App\Repositories\Interfaces;

use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Collection;

interface WishlistRepositoryInterface
{
    public function getByStudent(int $studentId): Collection;
    public function add(int $studentId, int $courseId): Wishlist;
    public function remove(int $studentId, int $courseId): bool;
    public function exists(int $studentId, int $courseId): bool;
}