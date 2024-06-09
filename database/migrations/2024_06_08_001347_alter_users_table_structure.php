<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('participacao_em_comunidades')->nullable();
            $table->json('historico_de_cursos')->nullable();
            $table->string('perfil_profissional')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('perfil_profissional');
            $table->dropColumn('historico_de_cursos');
            $table->dropColumn('participacao_em_comunidades');
        });
    }
};
