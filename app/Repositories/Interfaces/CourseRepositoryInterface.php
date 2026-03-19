<?php
namespace App\Repositories\Interfaces;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepositoryInterface{
    public function getAll(): Collection;
    public function findById(int $id): ?Course;
    public function create(array $data): Course;
    public function update(Course $course,array $data): Course;
    public function delete(Course $course): bool;
    public function getByTeacher(int $teacherId): Collection;
}