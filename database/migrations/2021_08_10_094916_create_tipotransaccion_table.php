<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipotransaccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipotransaccion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->enum('accion',['suma','resta']);
            $table->enum('estado',['activo','inactivo'])->default('activo');
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
        Schema::dropIfExists('tipotransaccion');
    }
}
