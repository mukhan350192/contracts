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
        Schema::create('bmg', function (Blueprint $table) {
            $table->id();
            $table->string('iin');
            $table->string('phone');
            $table->string('name');
            $table->string('lastName')->nullable();
            $table->string('middleName')->nullable();
            $table->unsignedInteger('document_id')->index();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bmg');
    }
};
