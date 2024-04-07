php artisan migrate:refresh --path=/database/migrations/2024_04_04_105344_create_qrcode_checks_table.php
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
        Schema::create('qrcode_checks', function (Blueprint $table) {
            $table->id();
            $table->string('qrcode_id')->nullable();
            $table->bigInteger('teacher_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->string('student_id')->nullable();
            $table->enum('status', ['มา', 'มาสาย', 'ขาด', 'ลากิจ', 'ลาป่วย'])->default('ขาด');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrcode_checks');
    }
};
