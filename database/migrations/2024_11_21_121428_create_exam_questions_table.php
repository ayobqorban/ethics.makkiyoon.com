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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('exam_id'); // Foreign Key to exams table
            $table->unsignedBigInteger('question_id'); // Foreign Key to questions table
            $table->timestamps(); // created_at and updated_at

            // Add foreign key constraints
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
