<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spellen', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('bezig');
            $table->dateTime('gestart_op');
            $table->foreignId('winnaar_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spellen');
    }
};