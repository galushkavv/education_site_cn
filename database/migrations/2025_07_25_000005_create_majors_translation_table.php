<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('majors_translation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->string('locale', 5);
            $table->string('name');
            $table->text('summary')->nullable();
            $table->text('introduction')->nullable();
            $table->text('detailed_description')->nullable();
            $table->text('subjects')->nullable();
            $table->timestamps();
            $table->unique(['major_id', 'locale']);
            $table->index('locale');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors_translation');
    }
};
