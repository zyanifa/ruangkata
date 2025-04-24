<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('reportable'); // This will create reportable_id and reportable_type columns
            $table->string('reason');
            $table->text('details')->nullable();
            $table->boolean('reviewed')->default(false);
            $table->timestamps();
            
            // Prevent a user from reporting the same content multiple times
            $table->unique(['user_id', 'reportable_id', 'reportable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};