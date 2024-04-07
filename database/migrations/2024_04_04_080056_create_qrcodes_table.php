php artisan migrate:refresh --path=/database/migrations/2024_04_04_080056_create_qrcodes_table.php
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
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->time('start_time')->nullable();
            $table->time('late_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('status', ['active', 'expired'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrcodes');
    }
};
