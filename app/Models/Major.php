<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends TranslatableModel
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'hidden'
        ];

    public function translations()
    {
        return $this->hasMany(MajorTranslation::class, 'major_id');
    }

    // Получить перевод именно на том языке, который указан
    public function getExactTranslation(string $locale)
    {
        return $this->translations->where('locale', $locale)->first();
    }

    public function universities()
    {
        return $this->belongsToMany(University::class, 'universities_majors', 'major_id', 'university_id')->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'majors_teachers_connection', 'major_id', 'teacher_id')->withTimestamps();
    }
}
