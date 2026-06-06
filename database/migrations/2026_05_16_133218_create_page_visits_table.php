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
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();

            $table->string('page_key')->index();
            $table->string('fingerprint', 64);

            $table->date('visit_date')->index();

            $table->foreignId('user_id')->nullable()->index();

            $table->ipAddress('ip')->nullable();
            $table->string('user_agent')->nullable();

            $table->boolean('is_bot')->default(false);

            $table->timestamps();

            $table->unique(['page_key', 'fingerprint', 'visit_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
