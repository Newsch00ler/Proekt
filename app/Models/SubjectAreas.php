<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectAreas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_subject_area',
        'name_subject_area'
    ];
}
