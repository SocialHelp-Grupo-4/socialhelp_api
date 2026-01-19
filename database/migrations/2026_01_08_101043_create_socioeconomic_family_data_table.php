<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('socioeconomic_family_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained();
            $table->foreignId('socioeconomic_data_id')->constrained('socioeconomic_data');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socioeconomic_family_data');
    }
};
