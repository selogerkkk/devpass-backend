<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilsTable extends Migration
{
    public function up()
    {
        Schema::create('perfils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('formacao');
            $table->string('habilidades');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfils');
    }
}
