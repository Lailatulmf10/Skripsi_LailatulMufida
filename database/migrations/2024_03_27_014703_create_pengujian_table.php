<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pengujian', function (Blueprint $table) {
      $table->id();
      $table->char('kode_pengujian', 127);
      $table->string('nama_penguji');
      $table->integer('min_support');
      $table->integer('min_confidence');
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
    Schema::dropIfExists('pengujian');
  }
};
