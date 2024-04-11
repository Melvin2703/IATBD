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
        Schema::create('aanvraags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_request')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreignId('user_id_post')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('accepted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aanvraags');
    }
};
