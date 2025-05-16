<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('seasons', function (Blueprint $table) {
            $table->increments('SeasonID'); // INT(11) UNSIGNED AUTO_INCREMENT
            $table->unsignedInteger('SeriesID'); // Поклапа се са series.SeriesID
            $table->unsignedInteger('season_number');
            $table->string('title')->nullable();
            $table->year('release_year')->nullable();
            $table->timestamps();
    
            // Страни кључ
            $table->foreign('SeriesID')
                  ->references('SeriesID')
                  ->on('series')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};
