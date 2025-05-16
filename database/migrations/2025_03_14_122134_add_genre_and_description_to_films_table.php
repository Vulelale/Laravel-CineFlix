<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('films', function (Blueprint $table) {
            $table->string('Genre', 50)->nullable()->after('IsSubscriptionRequired');
            $table->text('Description')->nullable()->after('Genre');
        });
    }

    public function down()
    {
        Schema::table('films', function (Blueprint $table) {
            $table->dropColumn(['Genre', 'Description']);
        });
    }
};
