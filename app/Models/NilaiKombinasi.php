<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKombinasi extends Model
{
  use HasFactory;

  protected $table = 'nilai_kombinasi';

  protected $fillable = [
    'kode_pengujian',
    'kode_kombinasi',
    'barang_id_a',
    'barang_id_b',
    'jumlah_transaksi',
    'support'
  ];

  public function barangA()
  {
    return $this->belongsTo(Barang::class, 'barang_id_a');
  }

  public function barangB()
  {
    return $this->belongsTo(Barang::class, 'barang_id_b');
  }

  public function dataBarang($kdBarang)
  {
    return Barang::where('id', $kdBarang)->first();
  }
}
