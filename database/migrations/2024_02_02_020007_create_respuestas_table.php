<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->string('respuesta');
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("pregunta_id")->nullable();

            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("pregunta_id")->references("id")->on("preguntas")->onDelete("cascade");

            $table->timestamps();
        });

        Schema::create('pregunta_respuesta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('respuesta_id')->constrained('respuestas');
            $table->foreignId('pregunta_id')->constrained('preguntas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuestas');
    }
};
