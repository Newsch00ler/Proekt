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
        Schema::create('works', function (Blueprint $table) {
            $table->id('id_work');
            $table->string('name_work');
            $table->string('language')->nullable();
            $table->boolean('creative');
            $table->boolean('signature')->nullable();
            $table->string('status');
            $table->unsignedTinyInteger('final_grade')->nullable();
            $table->unsignedBigInteger('id_protocol')->nullable();
            $table->float('original_percent')->nullable();
            $table->string('link_library')->unique();
            $table->string('link_file_extract_protocol')->unique();
            $table->string('link_pdf_file')->unique();
            $table->string('link_text_file')->unique();
            $table->timestamps();

            $table->foreign('id_protocol')->references('id_protocol')->on('protocols')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
