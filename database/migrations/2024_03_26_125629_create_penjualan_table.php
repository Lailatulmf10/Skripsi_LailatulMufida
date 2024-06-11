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
    Schema::create('penjualan', function (Blueprint $table) {
      $table->id();
      $table->char('no_faktur', 63);
      $table->foreignId('barang_id')->constrained('barang');
      $table->integer('qty');
      $table->integer('hari_ke');
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
    Schema::dropIfExists('penjualan');
  }
};
