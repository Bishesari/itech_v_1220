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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 0);
            $table->string('currency', 10)->default('IRR');
            $table->string('payment_method', 30)->default('online')->index();
            // online // cash // card_to_card // pos // wallet
            $table->string('gateway', 50)->nullable()->index();
            $table->string('status', 30)->default('initiated')->index();
            // initiated // pending // success // failed // canceled // refunded // partially_refunded

            $table->string('authority', 120)->nullable()->index();
            $table->string('transaction_id', 120)->nullable()->index();
            $table->string('ref_id', 120)->nullable()->index();
            $table->text('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            /*
            $table->unsignedBigInteger('amount'); // ریال
            $table->string('res_num')->unique();  // شماره سفارش شما
            $table->string('ref_num')->nullable(); // شماره مرجع بانک
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
