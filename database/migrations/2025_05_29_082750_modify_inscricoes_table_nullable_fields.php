<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inscricoes', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->foreignId('reuniao_id')->nullable()->change();
            $table->datetime('data_inscricao')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('inscricoes', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
            $table->foreignId('reuniao_id')->nullable(false)->change();
            $table->datetime('data_inscricao')->nullable(false)->change();
        });
    }
};