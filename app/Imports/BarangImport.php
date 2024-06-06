<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Kategori;
use Carbon\Carbon;
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
    if ($row[0] == 'No.' || $row[0] == null) {
      return;
    }

    $kategori = Kategori::where('nama', $row[1])->first();
    if (!$kategori) {
      $kategori = Kategori::create(['nama' => $row[1]]);
    }
    
    return new Barang([
      'kategori_id' => $kategori->id,
      'nama' => $row[2],
      'jumlah' => $row[3],
      'jumlah_transaksi' => $row[4],
      'created_at' => Carbon::createFromFormat('Y-m', $row[5]),
    ]);
  }
}
