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
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('EpisodeID'); // INT(11) UNSIGNED AUTO_INCREMENT
            $table->unsignedInteger('SeasonID'); // Поклапа се са seasons.SeasonID
            $table->unsignedInteger('episode_number');
            $table->string('title');
            $table->unsignedInteger('duration');
            $table->text('description')->nullable();
            $table->date('air_date')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
    
            // Страни кључ
            $table->foreign('SeasonID')
                  ->references('SeasonID')
                  ->on('seasons')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
