<?php

use App\Enums\Enums\IDType;
use App\Enums\Enums\MaritalStatus;
use App\Enums\Sex;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->enum('id_type', IDType::cases())->default(IDType::NationalID->value);
            $table->string('doc_path')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('sex', Sex::cases());
            $table->text('about')->nullable();
            $table->date('date_of_birth');
            $table->enum('marital_status', MaritalStatus::cases())->default(MaritalStatus::Single->value);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
