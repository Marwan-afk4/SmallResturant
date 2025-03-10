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
        Schema::table('available_tables', function (Blueprint $table) {
            $table->time('time_from')->after('date');
            $table->time('time_to')->after('time_from');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_tables', function (Blueprint $table) {
            //
        });
    }
};
