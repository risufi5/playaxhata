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
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('value', 6)->unique();
            $table->boolean('start_used')->default(false);
            $table->boolean('finish_used')->default(false);
            $table->timestamp('start_used_date')->nullable();
            $table->timestamp('finish_used_date')->nullable();
            $table->integer('score')->nullable();
            $table->string('video_url')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code');
    }
};
