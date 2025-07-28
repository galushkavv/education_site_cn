<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class University extends TranslatableModel
{
    use HasFactory;

    protected $fillable = ['logo_path', 'picture_path', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function translations()
    {
        return $this->hasMany(UniversityTranslation::class);
    }


    public function getExactTranslation(string $locale)
    {
        return $this->translations->where('locale', $locale)->first();
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'universities_majors', 'university_id', 'major_id');
    }
}
