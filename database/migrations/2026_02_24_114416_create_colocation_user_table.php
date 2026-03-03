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
        Schema::create('colocation_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colocation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unique(['colocation_id', 'user_id'], 'unique_membership');
            $table->enum('role', ['member', 'owner'])->default('member');
            $table->integer('debt')->default(0);
            $table->integer('sold')->default(0);
            $table->date('joined_at');
            $table->date('left_at')->nullable();
            $table->timestamps();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colocation_user');
    }
};
