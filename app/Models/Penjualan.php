<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
  use HasFactory;

  protected $table = 'penjualan';
  protected $guarded = [
    'id',
    'created_at',
    'updated_at',
  ];

  public function dataBarang($kdBarang)
  {
    return Barang::where('id', $kdBarang)->first();
  }

  public function hitungTransaksi($idTransaksi)
  {
    return $this->where('no_faktur', $idTransaksi)->count();
  }

  public function hitungTotalQt($idTransaksi)
  {
    return $this->where('no_faktur', $idTransaksi)->sum('qty');
  }

  public function getCreatedAt($idTransaksi)
  {
    return $this->where('no_faktur', $idTransaksi)->first()->created_at;
  }

  public function barang()
  {
    return $this->belongsTo(Barang::class);
  }
}
