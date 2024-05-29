<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
  use HasFactory;

  protected $table = 'barang';
  protected $guarded = [
    'id',
  ];

  public function kategori()
  {
    return $this->belongsTo(Kategori::class);
  }

  public function penjualan()
  {
    return $this->hasMany(Penjualan::class);
  }

  public function support()
  {
    return $this->hasMany(Support::class);
  }

  public function nilaiKombinasiA()
  {
    return $this->hasMany(NilaiKombinasi::class, 'barang_id_a');
  }

  public function nilaiKombinasiB()
  {
    return $this->hasMany(NilaiKombinasi::class, 'barang_id_b');
  }
}
