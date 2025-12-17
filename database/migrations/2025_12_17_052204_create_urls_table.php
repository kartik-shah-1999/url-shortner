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
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->string('original_url',500);
            $table->string('shortened_url',255);
            $table->string('hash',10);
            $table->unsignedInteger('hits')->default(0);
            $table->foreignId('user_id')->references('user_id')->on('user_companies');
            $table->foreignId('company_id')->references('company_id')->on('user_companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
