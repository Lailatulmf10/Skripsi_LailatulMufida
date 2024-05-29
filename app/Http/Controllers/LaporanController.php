<?php

namespace App\Http\Controllers;

use App\Models\Pengujian;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanController extends Controller
{
  public function index()
  {
    $totalPenjualan = Penjualan::count();
    if ($totalPenjualan == 0) {
      Alert::info('Info', 'Data penjualan masih kosong, silahkan tambahkan data penjualan terlebih dahulu');
      return redirect()->route('dashboard');
    }
    $dataPengujian = Pengujian::query()->paginate(10);
    return view('laporan.index', compact('dataPengujian'));
  }
}
