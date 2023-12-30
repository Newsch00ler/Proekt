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
        Schema::create('experts_works', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_work');
            $table->unsignedTinyInteger('criterion1');
            $table->unsignedTinyInteger('criterion2');
            $table->unsignedTinyInteger('criterion3');
            $table->unsignedTinyInteger('criterion4');
            $table->unsignedTinyInteger('criterion5');
            $table->timestamps();

            $table->primary(['id_user', 'id_work']);

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_work')->references('id_work')->on('works')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experts_works');
    }
};
