<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('works_subject_areas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_work');
            $table->unsignedBigInteger('id_subject_area');
            $table->timestamps();

            $table->primary(['id_work', 'id_subject_area']);

            $table->foreign('id_work')->references('id_work')->on('works')->onDelete('cascade');
            $table->foreign('id_subject_area')->references('id_subject_area')->on('subject_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works_subject_areas');
    }
};
