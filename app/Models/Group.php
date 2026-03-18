<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model{
    protected $fillable = ['course_id','name','max_students'];
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}