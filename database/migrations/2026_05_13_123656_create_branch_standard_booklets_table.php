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
        Schema::create('branch_standard_booklets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('standard_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title', 150);

            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();

            $table->unique(['branch_id', 'standard_id']);

            $table->index(['branch_id', 'standard_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_standard_booklets');
    }
};
