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
        Schema::create('consultation_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('position')->nullable();
            $table->string('region')->nullable();
            $table->string('business_field')->nullable();
            $table->string('tax_id')->nullable();
            $table->json('challenges')->nullable(); // Lưu mảng checkbox
            $table->string('other_challenge')->nullable();
            $table->text('biggest_challenge')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_surveys');
    }
};
