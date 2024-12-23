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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('idSecc')->nullable();
            $table->string('idSubSecc')->nullable();
            $table->string('codEquipo')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('det1')->nullable();
            $table->string('det2')->nullable();
            $table->string('det3')->nullable();
            $table->string('det4')->nullable();
            $table->string('det5')->nullable();
            $table->integer('histEquipo')->nullable();
            $table->string('creador')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
