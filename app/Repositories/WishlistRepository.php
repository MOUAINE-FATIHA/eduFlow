<?php

namespace App\Repositories;

use App\Models\Wishlist;
use App\Repositories\Interfaces\WishlistRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WishlistRepository implements WishlistRepositoryInterface
{
    public function getByStudent(int $studentId): Collection
    {
        return Wishlist::with('course.teacher:id,name')
                       ->where('student_id', $studentId)
                       ->get();
    }

    public function add(int $studentId, int $courseId): Wishlist
    {
        return Wishlist::create([
            'student_id' => $studentId,
            'course_id'  => $courseId,
        ]);
    }

    public function remove(int $studentId, int $courseId): bool
    {
        return Wishlist::where('student_id', $studentId)
                       ->where('course_id', $courseId)
                       ->delete() > 0;
    }

    public function exists(int $studentId, int $courseId): bool
    {
        return Wishlist::where('student_id', $studentId)
                       ->where('course_id', $courseId)
                       ->exists();
    }
}