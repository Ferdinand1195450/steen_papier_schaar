<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rondes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spel_id')->constrained('spellen')->cascadeOnDelete();
            $table->foreignId('speler_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('zet_id')->constrained('zetten')->cascadeOnDelete();
            $table->integer('ronde_nummer');
            $table->string('ronde_uitkomst')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rondes');
    }
};