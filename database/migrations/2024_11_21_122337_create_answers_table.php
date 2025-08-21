<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('user_id'); // User ID
            $table->unsignedBigInteger('form_id'); // Form ID
            $table->unsignedBigInteger('exam_id'); // Foreign Key to exams table
            $table->unsignedBigInteger('question_id'); // Foreign Key to questions table
            $table->unsignedBigInteger('selected_option_id'); // Foreign Key to options table
            $table->string('option_value')->nullable(); // Value of the selected option
            $table->timestamps(); // created_at and updated_at timestamps

            // Add foreign key constraints
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('selected_option_id')->references('id')->on('options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
