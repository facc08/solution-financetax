<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->longText('descripcion')->nullable();
            $table->enum('estado',['activo','inactivo'])->nullable();
            $table->unsignedBigInteger('tiposervicio_id')->nullable();
            $table->foreign('tiposervicio_id')->references('id')->on('tiposervicios')->onDelete('cascade');
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
        Schema::dropIfExists('services');
    }
}
