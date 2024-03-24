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
            $table->string('student_id')->nullable();
            $table->string('qrcode_id')->nullable();
            $table->string('status')->nullable();
            $table->string('subject_id')->nullable();
            $table->string('branch_id')->nullable();
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
