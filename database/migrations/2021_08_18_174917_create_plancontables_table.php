<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlancontablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plancontables', function (Blueprint $table) {
            $table->id();
            $table->string('cuenta')->nullable();
            $table->string('codigo')->nullable();
            $table->string('nivel')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('user_empresa_id')->nullable();
            $table->foreign('user_empresa_id')->references('id')->on('user_empresas')->onDelete('cascade');
            $table->unsignedBigInteger('tipocuenta_id')->nullable();
            $table->foreign('tipocuenta_id')->references('id')->on('tipocuentas')->onDelete('cascade');
            $table->enum('estado',['activo','inactivo'])->nullable();
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
        Schema::dropIfExists('plancontables');
    }
}
