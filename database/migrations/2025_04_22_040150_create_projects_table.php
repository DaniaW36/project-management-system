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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('proj_name');
            $table->text('proj_desc')->nullable();
            $table->enum('proj_status', ['Pending', 'In Progress', 'Completed', 'On Hold'])->default('Pending');
            $table->text('proj_statusDetails')->nullable();
            $table->date('proj_start_date')->nullable();
            $table->date('proj_end_date')->nullable();
            $table->timestamp('proj_latest_update')->nullable();
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->json('proj_attachments')->nullable(); // Store as JSON array
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
