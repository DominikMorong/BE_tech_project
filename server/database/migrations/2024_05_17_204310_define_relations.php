<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('time_periods', function(Blueprint $table) 
        {
            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');

            $table->unsignedBigInteger('talk_id')->unique()->nullable();
            $table->foreign('talk_id')
                  ->references('id')
                  ->on('talks')
                  ->onDelete('set null');
        });
        Schema::table('talks', function (Blueprint $table) {
            $table->unsignedBigInteger('speaker_id')->nullable();

            $table->foreign('speaker_id')
                  ->references('id')
                  ->on('speakers')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_periods', function(Blueprint $table) 
        {
            $table->dropForeign(['stage_id']);
            $table->dropColumn('stage_id');
            $table->dropForeign(['talk_id']);
            $table->dropColumn('talk_id');
        });
        Schema::table('talks', function (Blueprint $table) {
            $table->dropForeign(['speaker_id']);
            $table->dropColumn('speaker_id');
        });
    }
};
