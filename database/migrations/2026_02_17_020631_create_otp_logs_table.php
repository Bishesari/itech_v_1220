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

            // هویت کاربر
            $table->string('n_code', 20);
            $table->string('mobile', 15);

            // امنیت
            $table->string('otp_hash'); // OTP به صورت Hash ذخیره شود
            $table->unsignedTinyInteger('attempts')->default(0); // تعداد تلاش اشتباه

            // وضعیت
            $table->timestamp('expires_at'); // اعتبار 2 دقیقه‌ای
            $table->timestamp('verified_at')->nullable(); // زمان تأیید
            $table->boolean('verified')->default(false);

            // کنترل پایه ضد abuse
            $table->string('ip', 45)->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();

            // ایندکس‌های مهم برای performance
            $table->index(['n_code', 'created_at']);
            $table->index(['ip', 'created_at']);
            $table->index(['mobile', 'created_at']);
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
