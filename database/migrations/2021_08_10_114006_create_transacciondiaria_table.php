<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransacciondiariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciondiaria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuarioplan_id');
            $table->unsignedBigInteger('tipotransaccion_id');
            $table->unsignedBigInteger('plancuenta_id');
            $table->date('fecha_registro');
            $table->string('detalle');
            $table->decimal('tarifacero',10,3);
            $table->decimal('tarifadifcero',10,3);
            $table->decimal('iva',10,3);
            $table->decimal('importe',10,3);
            $table->string('archivo');
            $table->enum('estado',['activo','inactivo'])->default('activo');

            $table->timestamps();

            #Relaciones
            //$table->foreign('usuarioplan_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacciondiaria');
    }
}
