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
        Schema::create('booklet_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_standard_booklet_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('price', 12, 0);

            $table->timestamp('valid_from');
            $table->timestamp('valid_until')->nullable();

            $table->timestamps();

            $table->index(['branch_standard_booklet_id', 'valid_from']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booklet_prices');
    }
};
