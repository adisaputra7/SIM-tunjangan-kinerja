<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('divisi');
            $table->integer('user_id')->unsigned();
            $table->integer('skp_id')->unsigned();
            $table->integer('grade_id')->unsigned();
            $table->integer('tunjangan_id')->unsignend();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('skp_id')->references('id')->on('skps')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('grade_id')->references('id')->on('grades')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('tunjangan_id')->references('id')->on('tunjangans')
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
        Schema::dropIfExists('pegawais');
    }
}
