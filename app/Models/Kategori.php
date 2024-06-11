<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
  use HasFactory;

  protected $table = 'kategori';
  protected $guarded = [
    'id',
    'created_at',
    'updated_at',
  ];
  protected $fillable = [
    'nama'
  ];
  public $timestamps = false;

  public function barang()
  {
    return $this->hasMany(Barang::class);
  }
}
