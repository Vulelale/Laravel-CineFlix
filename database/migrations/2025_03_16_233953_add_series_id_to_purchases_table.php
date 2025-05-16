<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Purchases', function (Blueprint $table) {
            $table->unsignedInteger('SeriesID')
                  ->nullable()
                  ->after('FilmID');

            $table->foreign('SeriesID')
                  ->references('SeriesID')
                  ->on('series')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('Purchases', function (Blueprint $table) {
            $table->dropForeign(['SeriesID']);
            $table->dropColumn('SeriesID');
        });
    }
};
