<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('site_name');
            $table->enum('category', ['social', 'email', 'bank', 'work', 'shopping', 'other'])->default('other');
            $table->string('site_url')->nullable();
            $table->text('encrypted_data');
            $table->string('iv');
            $table->string('auth_tag');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};