<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pertemuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertemuan', function (Blueprint $table) {
            $table->id();
            $table->integer('pertemuan');
            $table->string('kelas_id');

            $table->string('materi');
            $table->tinyInteger('valid_dosen');
            $table->tinyInteger('valid_mahasiswa');
            $table->tinyInteger('open')->default(0);
            $table->integer('jumlah_mahasiswa')->default(0);
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
        Schema::dropIfExists('pertemuan');
    }
}
