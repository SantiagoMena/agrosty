<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formularios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            // columns
            $table->string('nombre', 100)
                ->charset('utf8')
                ->comment('Nombre del usuario')
                ->nullable(false);


            $table->string('email', 255)
                ->charset('utf8')
                ->comment('Email del usuario')
                ->nullable(false);

            $table->enum('asunto', ['Reclamo', 'Solicitud', 'Queja'])
                ->nullable(false);

            $table->longText('mensaje')
                ->charset('utf8')
                ->comment('Mensaje del usuario')
                ->nullable(false);
            
            $table->boolean('es_spam')
                ->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formularios');
    }
}
