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
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('following_user_id')->constrained('users')->onDelete('cascade');
            $table->unique(['user_id', 'following_user_id']); // a user can only follow another user once
            $table->boolean('accepted')->default(false); 
            $table->boolean('blocked')->default(false); 
            $table->boolean('muted')->default(false);
            $table->boolean('following')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
