<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class PenjualanImport implements ToCollection
{
  public function collection(Collection $collection)
  {
    $data = [];
    $date = now();
    foreach ($collection as $key => $columns) {
      if ($key == 0) {
        $date = Carbon::createFromFormat('Y-m', $columns[0])->startOfMonth()->startOfDay();
        continue;
      }

      if ($columns[0] == null) {
        continue;
      }

      if ($columns[0] == 'Hari') {
        foreach ($columns as $key => $column) {
          if ($column == 'Hari') {
            continue;
          }

          $barang = Barang::where('nama', $column)->first();
          if ($barang) {
            $data[$key] = $barang->id;
          }
        }
        continue;
      }

      if ((string)(int)$columns[0] == $columns[0]) {
        foreach ($data as $key => $barangId) {
          if ($columns[$key] > 0) {
            Penjualan::updateOrCreate([
              'no_faktur' => 'NF'.$date->year.sprintf("%02d", $date->month),
              'barang_id' => $barangId,
              'qty' => $columns[$key],
              'created_at' => $date,
              'hari_ke' => $columns[0],
            ]);
          }
        }
      }
    }
  }
}
