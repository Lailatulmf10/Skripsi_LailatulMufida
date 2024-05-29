<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;

class BarangImport implements ToModel
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    $current_date = date('Y-m-d H:i:s');
    return new Barang([
      'kategori_id' => $row[0],
      'nama' => $row[1],
      'jumlah' => $row[2],
      'created_at' => $current_date,
    ]);
  }
}
