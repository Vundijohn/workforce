<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('task_submission_id')->unique()->constrained()->restrictOnDelete(); // idempotent approval
            $table->unsignedBigInteger('amount_minor');
            $table->char('currency', 3)->default('KES');
            $table->string('status', 20)->default('pending')->index();
            $table->timestamp('available_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('earnings');
    }
};
