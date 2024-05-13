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
            works.id_work as id_work,
            works.name_work as name_work,
            STRING_AGG(distinct subject_areas.name_subject_area, \', \') as name_subject_area,
            works.original_percent as original_percent,
            works.created_at as created_at,
            works.final_grade as final_grade,
            works.status as status,
            works.id_protocol as id_protocol,
            SPLIT_PART(link_pdf_file, \'\\\', -1) AS file_name,
            STRING_AGG(distinct
                CONCAT(
                    SPLIT_PART(users.full_name, \' \', 1),
                    \' \',
                    CASE
                        WHEN array_length(string_to_array(users.full_name, \' \'), 1) > 2 THEN
                            LEFT(SPLIT_PART(users.full_name, \' \', 2), 1) || \'.\'
                        ELSE \'\'
                    END,
                    CASE
                        WHEN array_length(string_to_array(users.full_name, \' \'), 1) > 1 THEN
                            LEFT(SPLIT_PART(users.full_name, \' \', 3), 1) || \'.\'
                        ELSE \'\'
                    END
                ),
                \', \'
                ) as experts
            FROM works
            LEFT JOIN works_subject_areas ON works.id_work = works_subject_areas.id_work
            LEFT JOIN subject_areas ON works_subject_areas.id_subject_area = subject_areas.id_subject_area
            LEFT JOIN users_subject_areas ON subject_areas.id_subject_area = users_subject_areas.id_subject_area
            LEFT JOIN users ON users_subject_areas.id_user = users.id_user
            LEFT JOIN autors_works ON works.id_work = autors_works.id_work
            where users.id_user != autors_works.id_user and users."role" != \'Автор\' and users."role" != \'Администратор\'
            GROUP BY works.id_work
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
