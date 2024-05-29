<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    $totalBarang = Barang::count();
    $totalPenjualan = Penjualan::count();
    $totalJumlahBarang = Barang::sum('jumlah');
    $totalUser = User::count();
    $transaksiTerakhir = Penjualan::distinct()->take(10)->get(['no_faktur', 'created_at']);
    if ($totalJumlahBarang == 0) {
      $average = 0;
    } else {
      $average = $totalJumlahBarang / $totalBarang;
    }

    return view('dashboard', compact('totalBarang', 'totalPenjualan', 'totalJumlahBarang', 'transaksiTerakhir', 'totalUser', 'average'));
  }
}
