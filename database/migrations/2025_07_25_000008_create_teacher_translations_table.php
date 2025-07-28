<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teacher_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->text('about')->nullable();
            $table->timestamps();
            $table->unique(['teacher_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_translations');
    }
};
