<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->float('costo', 6, 3)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('tipoplan_id')->nullable();
            $table->foreign('tipoplan_id')->references('id')->on('tipoplans')->onDelete('cascade');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->unsignedBigInteger('subservice_id')->nullable();
            $table->foreign('subservice_id')->references('id')->on('subservices')->onDelete('cascade');
            $table->enum('estado',['pendiente','aprobada','en proceso'])->nullable();
            $table->unsignedBigInteger('especialista_id')->nullable();
            $table->foreign('especialista_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('shops');
    }
}
