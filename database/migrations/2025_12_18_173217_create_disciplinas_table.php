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
        Schema::create('disciplinas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nome');
            $table->integer('etapa');
            $table->string('responsavel');
            $table->string('carater');
            $table->integer('creditos');
            $table->text('descricao')->nullable();
            $table->json('prerequisitos')->nullable();
            $table->boolean('ead')->default(false);
            $table->boolean('extensionista')->default(false);
            $table->boolean('extracurricular')->default(true);
            $table->integer('id_grafo');
            $table->timestamps();
        });

        // Schema::create('competencia_disciplina', function (Blueprint $table) {
        //     $table->foreignId('disciplina_id')->constrained('disciplinas')->onDelete('cascade');
        //     $table->foreignId('competencia_id')->constrained('competencias')->onDelete('cascade'); 
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinas');
        //Schema::dropIfExists('competencia_disciplina');
    }
};
