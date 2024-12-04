<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_vigencia');
            $table->longText('descripcion')->nullable();
            $table->float('costo', 6, 3)->nullable();
            $table->enum('estado',['activo','inactivo'])->nullable();
            $table->unsignedBigInteger('tipoplan_id')->nullable();
            $table->foreign('tipoplan_id')->references('id')->on('tipoplans')->onDelete('cascade');
            $table->unsignedBigInteger('subservice_id')->nullable();
            $table->foreign('subservice_id')->references('id')->on('subservices')->onDelete('cascade');
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
        Schema::dropIfExists('plans');
    }
}
