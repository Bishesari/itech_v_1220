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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('item_type', 50)->index();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('title_snapshot', 200);
            $table->text('description_snapshot')->nullable();
            $table->decimal('unit_price', 12, 0);
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('discount_amount', 12, 0)->default(0);
            $table->decimal('tax_amount', 12, 0)->default(0);
            $table->decimal('total_price', 12, 0);
            $table->string('item_status', 30)->default('pending')->index();
            // pending // paid // in_progress // ready // delivered // completed // canceled // refunded

            $table->json('meta')->nullable();
            $table->timestamps();
            $table->index(['item_type', 'item_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
