<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('
            CREATE VIEW all_works AS
            SELECT
                works.name_work as name_work,
                STRING_AGG(subject_areas.name_subject_area, \', \') as name_subject_area,
                works.original_percent as original_percent,
                works.created_at as created_at,
                works.final_grade as final_grade,
                works.status as status,
	            SPLIT_PART(link_pdf_file, \'\\\', -1) AS file_name
            FROM works
            LEFT JOIN works_subject_areas ON works.id_work = works_subject_areas.id_work
            LEFT JOIN subject_areas ON works_subject_areas.id_subject_area = subject_areas.id_subject_area
            GROUP BY works.id_work;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS my_works;');
    }
};
