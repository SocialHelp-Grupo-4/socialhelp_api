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
        Schema::create('socioeconomic_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socioeconomic_data_type_id')->constrained('socioeconomic_data_types');
            $table->string('value');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socioeconomic_data');
    }
};
