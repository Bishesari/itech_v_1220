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
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // رابطه polymorphic
            $table->string('model_type'); // Question, QuestionOption, PracticalAnswer
            $table->unsignedBigInteger('model_id');

            $table->enum('type', ['image', 'pdf', 'video']); // نوع فایل
            $table->string('path', 255);                     // مسیر فایل
            $table->string('title')->nullable();             // عنوان فایل

            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medais');
    }
};
