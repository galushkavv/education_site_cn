<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'locale',
        'name',
        'summary',
        'article',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
