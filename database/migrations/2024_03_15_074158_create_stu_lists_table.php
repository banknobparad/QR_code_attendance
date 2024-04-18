php artisan migrate:refresh --path=/database/migrations/2024_03_15_074158_create_stu_lists_table.php
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
        Schema::create('stu_lists', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id')->nullable();
            $table->string('student_id', 10)->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stu_lists');
    }
};
