
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reunioes', function (Blueprint $table) {
            $table->string('titulo')->nullable()->change();
            $table->text('descricao')->nullable()->change();
            $table->string('tema_literario')->nullable()->change();
            $table->datetime('data_reuniao')->nullable()->change();
            $table->string('local')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('reunioes', function (Blueprint $table) {
            $table->string('titulo')->nullable(false)->change();
            $table->text('descricao')->nullable(false)->change();
            $table->string('tema_literario')->nullable(false)->change();
            $table->datetime('data_reuniao')->nullable(false)->change();
            $table->string('local')->nullable(false)->change();
        });
    }
};