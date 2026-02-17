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
        Schema::create('otp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45)->index();
            $table->string('n_code', 20)->index();
            $table->string('contact_value', 191)->index();
            $table->string('otp_hash');
            $table->unsignedTinyInteger('attempts')->default(0); // تعداد تلاش اشتباه
            $table->timestamp('expires_at')->index(); // اعتبار 2 دقیقه‌ای
            $table->timestamp('verified_at')->nullable(); // زمان تأیید
            $table->boolean('verified')->default(false);
            $table->timestamps();
            $table->index('created_at');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_logs');
    }
};
