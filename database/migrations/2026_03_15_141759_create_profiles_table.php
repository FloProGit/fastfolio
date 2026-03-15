<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->json('title');
            $table->json('bio');
            $table->string('avatar')->nullable();
            $table->json('resume_url')->nullable();
            $table->json('location')->nullable();
            $table->string('email');
            $table->json('socials')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('seo_desc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
