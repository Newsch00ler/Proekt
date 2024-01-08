<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_subject_area',
        'name_subject_area'
    ];

    public function works() {
        return $this->belongsToMany(Work::class, 'works_subject_areas', 'id_subject_area', 'id_work');
    }
}
