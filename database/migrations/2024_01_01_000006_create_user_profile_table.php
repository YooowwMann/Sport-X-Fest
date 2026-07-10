<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('user_profile')) {
            Schema::create('user_profile', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('role');
                $table->string('email');
                $table->string('foto')->nullable();
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profile');
    }
};