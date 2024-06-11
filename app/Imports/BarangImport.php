<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class BarangImport implements ToCollection
{
  public function collection(Collection $rows)
  {
    foreach ($rows as $row) {
      if ($row[0] == 'No.' || $row[0] == null) {
        continue;
      }
  
      $kategori = Kategori::where('nama', $row[1])->first();
      if (!$kategori) {
        $kategori = Kategori::create(['nama' => $row[1]]);
      }
      
      Barang::updateOrCreate([
        'kategori_id' => $kategori->id,
        'nama' => $row[2],
        'created_at' => Carbon::createFromFormat('Y-m', $row[4])->startOfMonth()->startOfDay(),
      ],[
        'jumlah' => $row[3],
      ]);
    }
  }
}
