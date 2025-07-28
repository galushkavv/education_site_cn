<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends TranslatableModel
{
    use HasFactory;

    protected $fillable = ['photo_path', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function translations()
    {
        return $this->hasMany(TeacherTranslation::class);
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'majors_teachers_connection')->withTimestamps();
    }

    // Получить перевод именно на том языке, который указан
    public function getExactTranslation(string $locale)
    {
        return $this->translations->where('locale', $locale)->first();
    }
}
