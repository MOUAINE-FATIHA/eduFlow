<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    ) {}
    public function index(): JsonResponse {
        $courses = $this->courseService->getAllCourses(); 
        return response()->json([
            'data' => $courses,
        ]);
    }
    //details de cours 
    public function show(int $id): JsonResponse {
        try {
            $course = $this->courseService->getCourseById($id);
        } catch (\Exception $e) {
            
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } 

        return response()->json(['data' => $course]);
    }



    //cours d'enseignant
    public function myCourses(): JsonResponse
    {
        $courses = $this->courseService->getMyCoures(auth()->id());
        return response()->json(['data' => $courses]);
    }
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'=> 'required|string|max:255',
            'description' => 'nullable|string',
            'price'=> 'required|numeric|min:0',
            'category'=> 'nullable|string|max:100',
        ]);

        $course = $this->courseService->createCourse($validated, auth()->id());
        return response()->json([
            'message' => 'Cours cree avec succes.',
            'data' => $course,
        ], 201);
    }
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'title'=> 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price'=> 'sometimes|numeric|min:0',
            'category'=> 'nullable|string|max:100',
        ]);

        try {
            $course = $this->courseService->updateCourse($id,$validated, auth()->id());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'message'=> 'Cours mis à jour avec succes.',
            'data'=> $course,
        ]);
    }

    public function destroy(int $id): JsonResponse{
        try {
            $this->courseService->deleteCourse($id, auth()->id());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'le cours etait supprimé']);
    }
}