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
        Schema::create('verigram_sign_histories', function (Blueprint $table) {
            $table->id();
            $table->string('firstName',50);
            $table->string('gender',1);
            $table->string('iin',12);
            $table->string('lastName',50);
            $table->string('middleName',50)->nullable();
            $table->string('originalImage',100)->nullable();
            $table->string('facePicture',100)->nullable();
            $table->string('best_frame',100)->nullable();
            $table->unsignedInteger('shortID')->index();
            $table->string('phone',12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verigram_sign_histories');
    }
};
