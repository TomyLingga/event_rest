<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');     //author yg buat event
            $table->string('namaEvent');
            $table->date('tanggalEvent');
            $table->time('jamEvent');
            $table->integer('jumlahPesertaEvent');
            $table->string('lokasiEvent');
            $table->string('brosurEvent');
            $table->text('deskripsiEvent');
            $table->string('qrEvent');
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
        Schema::dropIfExists('events');
    }
}
