<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'locale',
        'first_name',
        'middle_name',
        'last_name',
        'about',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
