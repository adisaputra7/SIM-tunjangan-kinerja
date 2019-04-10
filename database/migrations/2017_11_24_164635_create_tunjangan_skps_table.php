<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTunjanganSkpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tunjangan_skps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nilai');
            $table->float('potongan');
            $table->integer('skp_id')->unsigned();
            $table->timestamps();

            $table->foreign('skp_id')->references('id')->on('skps')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tunjangan_skps');
    }
}
