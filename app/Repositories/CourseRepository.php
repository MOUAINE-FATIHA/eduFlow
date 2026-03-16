<?php

namespace App\Repositories;

use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CourseRepository implements CourseRepositoryInterface
{
    public function getAll(): Collection
    {
        return Course::with('teacher:id,name,email')->get();
    }

    public function findById(int $id): ?Course
    {
        return Course::with('teacher:id,name,email')->find($id);
    }

    public function create(array $data): Course
    {
        return Course::create($data);
    }

    public function update(Course $course, array $data): Course
    {
        $course->update($data);
        return $course->fresh();
    }

    public function delete(Course $course): bool
    {
        return $course->delete();
    }

    public function getByTeacher(int $teacherId): Collection
    {
        return Course::with('teacher:id,name,email')
                     ->where('teacher_id', $teacherId)
                     ->get();
    }
}