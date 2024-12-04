<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTarjetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tarjetas', function (Blueprint $table) {
            $table->id();
            $table->string('n_tarjeta')->nullable();
            $table->string('ano_vencimiento')->nullable();
            $table->string('mes_vencimiento')->nullable();
            $table->string('cvv')->nullable();
            $table->string('tipo')->nullable();
            $table->string('propietario')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_tarjetas');
    }
}
