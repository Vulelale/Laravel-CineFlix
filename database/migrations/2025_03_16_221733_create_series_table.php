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
        Schema::create('series', function (Blueprint $table) {
            
            $table->increments('SeriesID');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('genre')->nullable();
            $table->date('release_date');
            $table->decimal('price', 8, 2)->default(0);
            $table->boolean('is_subscription_required')->default(false);
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
