<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('abbreviation', 50)->nullable();
            $table->string('logo_path')->nullable();
            $table->string('picture_path')->nullable();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->boolean('hidden')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
