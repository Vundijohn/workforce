<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status', 20)->default('submitted')->index();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['project_id', 'user_id']); // one application per worker per project
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_applications');
    }
};
