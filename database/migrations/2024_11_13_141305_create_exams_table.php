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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // معرف المستخدم
            $table->enum('status', ['ongoing', 'completed', 'failed']); // حالة الاختبار
            $table->timestamp('start_time')->nullable(); // وقت بدء الاختبار
            $table->timestamp('end_time')->nullable(); // وقت انتهاء الاختبار
            $table->integer('attempts')->default(1); // عدد المحاولات المتبقية
            $table->timestamps(); // وقت الإنشاء والتحديث
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
