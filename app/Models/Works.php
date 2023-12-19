<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Works extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_work',
        'name_subject_area',
        'original_percent',
        'download_data',
        'final_grade',
        'verification_status'
    ];

    protected function data(): Attribute{
        return Attribute::make(
            get: fn ($value) => json_decode($value,true),
            get: fn ($value) => json_encode($value)
        );
    }
}
