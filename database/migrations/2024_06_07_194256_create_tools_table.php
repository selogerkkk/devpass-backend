<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!(Schema::hasTable('tools'))) {
            Schema::create('tools', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('link');
                $table->string('description');
                $table->json('tags');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
