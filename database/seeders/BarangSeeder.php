<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $barang = [
      [
        'nama' => 'Kaos Kaki',
        'kategori_id' => 5,
        'jumlah' => 200,
      ],
      [
        'nama' => 'Celana Pendek',
        'kategori_id' => 4,
        'jumlah' => 180,
      ],
      [
        'nama' => 'Celana Panjang',
        'kategori_id' => 4,
        'jumlah' => 250,
      ],
      [
        'nama' => 'Kemeja',
        'kategori_id' => 3,
        'jumlah' => 150,
      ],
      [
        'nama' => 'Jaket',
        'kategori_id' => 2,
        'jumlah' => 100,
      ],
      [
        'nama' => 'Smartphone',
        'kategori_id' => 1,
        'jumlah' => 320,
      ],
      [
        'nama' => 'Laptop',
        'kategori_id' => 1,
        'jumlah' => 150,
      ],
      [
        'nama' => 'Tablet',
        'kategori_id' => 1,
        'jumlah' => 82,
      ],
      [
        'nama' => 'Printer',
        'kategori_id' => 1,
        'jumlah' => 200,
      ],
      [
        'nama' => 'Scanner',
        'kategori_id' => 1,
        'jumlah' => 100,
      ],
      [
        'nama' => 'Roti',
        'kategori_id' => 6,
        'jumlah' => 203,
      ],
      [
        'nama' => 'Kue',
        'kategori_id' => 6,
        'jumlah' => 200,
      ],
      [
        'nama' => 'Mie Instan',
        'kategori_id' => 6,
        'jumlah' => 100,
      ],
    ];

    foreach ($barang as $item) {
      Barang::create($item);
    }
  }
}
