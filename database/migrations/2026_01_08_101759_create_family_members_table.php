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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('relationship'); // pai, mãe, filho, avó...
            $table->integer('age')->nullable();
            $table->string('sex', 10)->nullable();

            $table->string('profession')->nullable();
            $table->boolean('is_head')->default(false); // chefe do agregado
            $table->boolean('has_income')->default(false);

            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
