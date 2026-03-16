<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RecommendationService
{
    public function getRecommendedCourses(): Collection
    {
        $user = Auth::user();

        // Récupérer les IDs des intérêts de l'étudiant
        $interestIds = $user->interests()->pluck('interests.id');

        if ($interestIds->isEmpty()) {
            // Pas d'intérêts → retourner tous les cours
            return Course::with('teacher:id,name')->get();
        }

        // Retourner les cours liés aux intérêts de l'étudiant
        return Course::with(['teacher:id,name', 'interests'])
            ->whereHas('interests', function ($query) use ($interestIds) {
                $query->whereIn('interests.id', $interestIds);
            })
            ->get();
    }

    public function syncUserInterests(array $interestIds): void
    {
        Auth::user()->interests()->sync($interestIds);
    }
}