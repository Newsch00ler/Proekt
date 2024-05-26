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
            $table->boolean('creative')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->float('final_grade')->nullable();
            $table->unsignedBigInteger('id_protocol')->nullable();
            $table->float('original_percent')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('publishing_year')->nullable();
            $table->integer('pages_number')->nullable();
            $table->string('link_file_extract_protocol')->unique();
            $table->string('link_pdf_file')->unique();
            $table->string('link_text_file')->unique();
            $table->string('link_text_percent1')->nullable();
            $table->float('percent1')->nullable();
            $table->string('link_text_percent2')->nullable();
            $table->float('percent2')->nullable();
            $table->string('link_text_percent3')->nullable();
            $table->float('percent3')->nullable();
            $table->string('link_text_percent4')->nullable();
            $table->float('percent4')->nullable();
            $table->string('link_text_percent5')->nullable();
            $table->float('percent5')->nullable();
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
