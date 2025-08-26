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
       Schema::create('ratings', function (Blueprint $table) {
    $table->id('RatingID');
    $table->unsignedBigInteger('UserID');
    $table->unsignedBigInteger('FilmID')->nullable();
    $table->unsignedBigInteger('SeriesID')->nullable();
    $table->tinyInteger('rating'); // 1 do 5
    $table->timestamps();

    $table->foreign('UserID')->references('UserID')->on('Users')->onDelete('cascade');
    $table->foreign('FilmID')->references('FilmID')->on('Films')->onDelete('cascade');
    $table->foreign('SeriesID')->references('SeriesID')->on('series')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
