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
        Schema::create('question_scopes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('question_id')->constrained()->cascadeOnDelete();

            $table->enum('scope', ['national', 'county', 'city']);

            $table->foreignId('province_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['question_id', 'scope', 'province_id', 'city_id'], 'uq_question_scope');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_scopes');
    }
};
