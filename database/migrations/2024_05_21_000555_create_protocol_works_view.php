<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('
            CREATE VIEW protocol_works AS
            select
            works."type" as type,
            case
                when works."type" in (\'Учебник с грифом\', \'Учебное пособие с грифом\') then \'С грифом\'
                else \'Без грифа\'
            end as stamp,
            works.name_work as name_work,
            users.full_name as autor,
            STRING_AGG(distinct subject_areas.name_subject_area, \', \') as name_subject_area,
            works.pages_number as pages_number,
            works.publisher as publisher,
            works.publishing_year as publishing_year
            FROM works
            LEFT JOIN works_subject_areas ON works.id_work = works_subject_areas.id_work
            LEFT JOIN subject_areas ON works_subject_areas.id_subject_area = subject_areas.id_subject_area
            LEFT JOIN autors_works ON works.id_work = autors_works.id_work
            LEFT JOIN users ON autors_works.id_user = users.id_user
            --where works.status = \'Проверена\' -----------СНЯТЬ
            GROUP BY works.id_work, users.full_name
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS protocol_works;');
    }
};
