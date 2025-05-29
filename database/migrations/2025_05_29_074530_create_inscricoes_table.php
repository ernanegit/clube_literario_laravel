<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('reuniao_id')->constrained('reunioes')->onDelete('cascade');
            $table->datetime('data_inscricao');
            $table->text('comentarios')->nullable();
            $table->boolean('confirmada')->default(false);
            $table->timestamps();
            
            $table->unique(['user_id', 'reuniao_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inscricoes');
    }
};