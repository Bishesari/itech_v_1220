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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            // وابستگی آموزشی
            $table->foreignId('standard_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();

            // نوع سوال و سطح
            $table->enum('type', ['written', 'practical']);

            // طراح سوال
            $table->foreignId('designer_id')->constrained('users')->cascadeOnDelete();

            // متن سوال
            $table->text('question_text')->nullable();

            // سوال پرتکرار نهایی سازمان
            $table->boolean('is_frequent_final')->default(false);

            // وضعیت فعال
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
