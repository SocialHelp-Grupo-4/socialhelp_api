<?php

use App\Enums\Enums\InstitutionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('nif')->unique();
            $table->string('name');
            $table->string('email');
            $table->text('description')->nullable();
            $table->enum('status', InstitutionStatus::cases())->default(InstitutionStatus::PENDING->value);
            $table->string('logo')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('category_institution_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
