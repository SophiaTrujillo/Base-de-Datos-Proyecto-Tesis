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
        Schema::create('tarea_moodles', function (Blueprint $table) {
            $table->id();
            $table->string('curso');
            $table->string('titulo');
            $table->text('descripcion');
            $table->date('fecha_entrega');
            $table->string('enlace_moodle');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea_moodles');
    }
};
