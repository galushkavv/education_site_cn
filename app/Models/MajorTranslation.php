<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MajorTranslation extends Model
{
    use HasFactory;

    protected $table = 'majors_translation';

    protected $fillable = [
        'major_id',
        'locale',
        'name',
        'summary',
        'introduction',
        'detailed_description',
        'subjects'
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
