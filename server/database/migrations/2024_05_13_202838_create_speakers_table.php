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
        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->string('firstName', '64');
            $table->string('lastName', '64');
            $table->string('imgUrl', '512');
            $table->string('description', '1024');
            $table->string('descriptionShort', '255');
            $table->string('xFormerlyKnownAsTwitterProfile', '512');
            $table->string('facebookProfile', '512');
            $table->string('personalPage', '512');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
