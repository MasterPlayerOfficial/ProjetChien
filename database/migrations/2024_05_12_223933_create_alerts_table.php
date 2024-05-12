<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alert', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idAnimal')->constrained();
            $table->boolean('inProgress');
            $table->date('dateStart');
            $table->date('dateEnd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert');
    }
};
