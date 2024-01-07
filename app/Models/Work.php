<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fields = [
        'id_work',
        'name_work',
        'language',
        'creative',
        'signature',
        'verification_status',
        'final_grade',
        'id_protocol',
        'original_percent',
        'download_data', // в БД это поле created_at
        'link_help_file_library',
        'link_file_extract_protocol',
        'link_text_file'
    ];

    public function subjectAreas() {
        return $this->belongsToMany(SubjectArea::class, 'works_subject_areas', 'id_work', 'id_subject_area');
    }

    // между таблицами не создаются модели под разбиение связи многие-ко-многим
    // использование как ниже не работает (надо делать через запрос к БД)
    // $work = Work::find(1);
    // $subjectAreas = $work->subjectAreas;$work = Work::find(1);
    // $subjectAreas = $work->subjectAreas;
    // foreach ($subjectAreas as $subjectArea) {
    //     // Доступ к свойствам предметной области
    //     echo $subjectArea->name;
    // }

    protected function data(): Attribute{
        return Attribute::make(
            get: fn ($value) => json_decode($value,true),
            get: fn ($value) => json_encode($value)
        );
    }
}
