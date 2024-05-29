<?php

namespace App\Console\Commands;

use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateFakePenjualan extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'createFakePenjualan {tf}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    Penjualan::truncate();
    $argument = $this->argument('tf');
    $bahanArgument = explode('=', $argument);
    for ($i = 0; $i < $bahanArgument[0]; $i++) {
      $kdFaktur = Str::uuid();
      $jarak = rand(0, 15);
      $dataBarangTemp = array();
      $dataBarang = Barang::all();
      foreach ($dataBarang as $barang) {
        array_push($dataBarangTemp, $barang->id);
      }
      shuffle($dataBarangTemp);
      for ($j = 0; $j <= $jarak; $j++) {
        $penjualan = new Penjualan();
        $penjualan->no_faktur = $kdFaktur;
        $penjualan->barang_id = $dataBarangTemp[$j];
        $penjualan->qty = rand(50, 100);
        $penjualan->save();
      }
    }
    echo "Data penjualan berhasil dibuat sebanyak " . $jarak . " data\n";
  }
}
