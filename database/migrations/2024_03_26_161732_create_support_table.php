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
    Schema::create('support', function (Blueprint $table) {
      $table->id();
      $table->char('kode_pengujian', 127);
      $table->foreignId('barang_id')->constrained('barang');
      $table->integer('jumlah_transaksi');
      $table->float('support');
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
    Schema::dropIfExists('support');
  }
};
