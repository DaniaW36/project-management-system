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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('task_name');
            $table->text('task_desc')->nullable();
            $table->enum('task_status', ['not_started', 'pending', 'in_progress', 'completed'])->default('not_started');
            $table->date('due_date')->nullable();
            $table->enum('task_priority', ['low', 'medium', 'high'])->default('low');
            $table->json('task_attachments')->nullable(); // Store as JSON array
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
