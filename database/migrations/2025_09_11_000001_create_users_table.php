<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document', 18)->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('type', ['comum', 'lojista'])->default('comum');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // Adicionado para exclusão lógica
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};