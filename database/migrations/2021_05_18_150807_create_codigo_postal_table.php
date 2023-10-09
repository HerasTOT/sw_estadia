<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigoPostalTable extends Migration
{
    public function up()
    {
        Schema::create('c_cod_postal', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_postal');
            $table->string('n_estado');
            $table->string('n_municipio');
            $table->string('n_colonia');
            $table->integer('id_entidad_federativa'); 
            $table->integer('id_municipio');   
            $table->string('id_estado_sepomex')->nullable(true);
            $table->string('id_municipio_sepomex')->nullable(true);
            $table->string('id_colonia_sepomex')->nullable(true);
            $table->string('id_municipio_sireho')->nullable(true);
            $table->string('id_colonia_sireho')->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('codigo_postal');
            $table->index('id_entidad_federativa');
            $table->index('id_municipio');
        });
    }

    public function down()
    {
        Schema::dropIfExists('c_cod_postal');
    }
}
