<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Pengujian;
use App\Models\Barang;
use App\Models\NilaiKombinasi;
use App\Models\Penjualan;
use App\Models\Support;

class AprioriController extends Controller
{
  public function index()
  {
    return view('apriori.index');
  }

  public function prosesAnalisaApriori(Request $request)
  {
    $totalPenjualan = Penjualan::count();
    if ($totalPenjualan < 3) {
      Alert::info('Info', 'Data penjualan kurang, silahkan tambahkan data penjualan terlebih dahulu');
      return redirect()->route('dashboard');
    } else {
      $minSupp = $request->min_support;
      $minConfidence = $request->min_confidence;

      // Insert data pengujian
      $kdPengujian = Str::uuid();
      $pengujian = new Pengujian();
      $pengujian->kode_pengujian = $kdPengujian;
      $pengujian->nama_penguji = $request->nama_penguji;
      $pengujian->min_support = $minSupp;
      $pengujian->min_confidence = $minConfidence;
      $totalBarang = Barang::count();

      // cari nilai support
      $dataBarang = Barang::all();
      foreach ($dataBarang as $barang) {
        $idBarang = $barang->id;
        $totalTransaksi = Penjualan::where('barang_id', $idBarang)->count();
        $nSupport = ($totalTransaksi / $totalBarang) * 100;
        $supp = new Support();
        $supp->kode_pengujian = $kdPengujian;
        $supp->barang_id = $idBarang;
        $supp->support = $nSupport;
        $supp->save();
      }

      // Kombinasi 2 item set
      $qProdukA = Support::where('kode_pengujian', $kdPengujian)->where('support', '>=', $minSupp)->get();
      foreach ($qProdukA as $produkA) {
        $kdProdukA = $produkA->barang_id;
        $qProdukB = Support::where('kode_pengujian', $kdPengujian)->where('support', '>=', $minSupp)->get();
        foreach ($qProdukB as $produkB) {
          $kdProdukB = $produkB->barang_id;
          $jumB = NilaiKombinasi::where('barang_id_a', $kdProdukA)->count();
          if ($jumB > 0) {
          } else {
            if ($kdProdukA == $kdProdukB) {
            } else {
              $kdKombinasi = Str::uuid();
              $nk = new NilaiKombinasi();
              $nk->kode_pengujian = $kdPengujian;
              $nk->kode_kombinasi = $kdKombinasi;
              $nk->barang_id_a = $kdProdukA;
              $nk->barang_id_b = $kdProdukB;
              $nk->jumlah_transaksi = 0;
              $nk->support = 0;
              $nk->save();
            }
          }
        }
      }

      // Kombinasi 2 itemset phase 2
      $nilaiKombinasi = NilaiKombinasi::where('kode_pengujian', $kdPengujian)->get();
      foreach ($nilaiKombinasi as $nk) {
        $kdKombinasi = $nk->kode_kombinasi;
        $kdProdukA = $nk->barang_id_a;
        $kdProdukB = $nk->barang_id_b;

        // cari total transaksi
        $dataFaktur = Penjualan::distinct()->get(['no_faktur']);
        $fnTransaksi = 0;
        foreach ($dataFaktur as $faktur) {
          $noFaktur = $faktur->no_faktur;
          $qBonTransaksiA = Penjualan::where('no_faktur', $noFaktur)->where('barang_id', $kdProdukA)->count();
          $qBonTransaksiB = Penjualan::where('no_faktur', $noFaktur)->where('barang_id', $kdProdukB)->count();
          if ($qBonTransaksiA == 1 && $qBonTransaksiB == 1) {
            $fnTransaksi++;
          }
        }
        $suppport = ($fnTransaksi / $totalBarang) * 100;
        NilaiKombinasi::where('kode_kombinasi', $kdKombinasi)->update(
          [
            'jumlah_transaksi' => $fnTransaksi,
            'support' => $suppport
          ]
        );
      }

      $pengujian->save();
      Alert::success('Berhasil', 'Data berhasil disimpan');
      return redirect()->route('apriori.index');
    }
  }

  public function hasilAnalisaApriori($kdPengujian)
  {
    $dataPengujian = Pengujian::where('kode_pengujian', $kdPengujian)->first();
    $dataSupportBarang = Support::where('kode_pengujian', $kdPengujian)->get();
    $dataMinSupp = Support::where('kode_pengujian', $kdPengujian)->where('support', '>=', $dataPengujian->min_support)->get();
    $dataKombinasiItemSet = NilaiKombinasi::where('kode_pengujian', $kdPengujian)->get();
    $dataMinConfidence = NilaiKombinasi::where('kode_pengujian', $kdPengujian)->where('support', '>=', $dataPengujian->min_confidence)->get();
    $totalBarang = Barang::count();

    return view('apriori.hasil', compact('dataPengujian', 'dataSupportBarang', 'dataMinSupp', 'dataKombinasiItemSet', 'dataMinConfidence', 'totalBarang'));
  }

  public function cetakAnalisa($kdPengujian)
  {
    $dataPengujian = Pengujian::where('kode_pengujian', $kdPengujian)->first();
    $dataMinConfidence = NilaiKombinasi::where('kode_pengujian', $kdPengujian)->where('support', '>=', $dataPengujian->min_confidence)->get();
    $totalBarang = Barang::count();
    $pdf = PDF::loadView('apriori.cetak', compact('dataPengujian', 'dataMinConfidence', 'totalBarang'));
    return $pdf->stream();
  }
}
