<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class PenjualanImport implements ToModel
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    $namaBarang = $row[1];
    $dataBarang = Barang::where('nama', $namaBarang)->first();
    $qty = $row[2];

    if ($qty >= 50) {
      return new Penjualan([
        'no_faktur' => $row[0],
        'barang_id' => $dataBarang->id ?? 1,
        'qty' => $qty,
      ]);
    } else {
      return null;
    }
  }
}
