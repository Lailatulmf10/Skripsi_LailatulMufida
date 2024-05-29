<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengujian extends Model
{
  use HasFactory;

  protected $table = 'pengujian';

  protected $fillable = [
    'kode_pengujian',
    'nama_penguji',
    'min_support',
    'min_confidence',
  ];

  public function totalPolaProduk($kdPengujian, $confidence)
  {
    return NilaiKombinasi::where('kode_pengujian', $kdPengujian)
      ->where('support', '>=', $confidence)
      ->count();
  }
}
