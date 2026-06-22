<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spel_speler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spel_id')->constrained('spellen')->cascadeOnDelete();
            $table->foreignId('speler_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spel_speler');
    }
};