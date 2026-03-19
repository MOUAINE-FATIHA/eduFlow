<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CourseService
{
    public function __construct(
        private CourseRepositoryInterface $courseRepository
    ) {}
    public function getAllCourses(): Collection
    {
        return $this->courseRepository->getAll();
    }

    public function getCourseById(int $id): Course
    {
        $course = $this->courseRepository->findById($id);
        if (!$course) {
            throw new \Exception('Cours introuvable.', 404);
        }

        return $course;
    }
    public function getMyCoures(int $teacherId): Collection
    {
        return $this->courseRepository->getByTeacher($teacherId);
    }

    public function createCourse(array $data, int $teacherId): Course
    {
        return $this->courseRepository->create([
            'teacher_id'=> $teacherId,
            'title' => $data['title'],
            'description'=> $data['description'] ?? null,
            'price' => $data['price'],
            'category'=> $data['category'] ?? null,
        ]);
    }

    public function updateCourse(int $courseId, array $data, int $teacherId): Course
    {
        $course = $this->courseRepository->findById($courseId);

        if (!$course) {
            throw new \Exception('Cours introuvable.', 404);
        }
        if ($course->teacher_id !== $teacherId) {
            throw new \Exception('pas autorise à modifier ce cours', 403);
        }

        return $this->courseRepository->update($course, $data);
    }

    public function deleteCourse(int $courseId, int $teacherId): bool
    {
        $course = $this->courseRepository->findById($courseId);

        if (!$course) {
            throw new \Exception('Cours introuvable.', 404);
        }
        if ($course->teacher_id !== $teacherId) {
            throw new \Exception('pas autorise à supprimer ce cours', 403);
        }

        return $this->courseRepository->delete($course);
    }
}