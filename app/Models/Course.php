<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['teacher_id', 'title', 'description', 'price', 'category'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class);
    }
}