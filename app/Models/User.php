<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',        // Added
        'grade',       // Added
        'status',      // Added
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper methods for role checking
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasPaid(): bool
    {
        return $this->status === 'paid';
    }

    // Courses/Subjects a teacher teaches
    public function teachingSubjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    // Courses/Subjects a student is enrolled in (using enrollments pivot table)
    public function enrolledSubjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollments', 'user_id', 'subject_id')
                    ->withTimestamps();
    }

    // If you need a separate enrollment model relationship
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'user_id');
    }
}
