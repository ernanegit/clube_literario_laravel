<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reunioes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('tema_literario');
            $table->string('livro_sugerido')->nullable();
            $table->string('autor_livro')->nullable();
            $table->datetime('data_reuniao');
            $table->string('local');
            $table->integer('limite_participantes')->default(20);
            $table->boolean('ativa')->default(true);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reunioes');
    }
};