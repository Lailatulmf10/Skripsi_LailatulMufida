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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AprioriController extends Controller
{
  public function index()
  {
    $semuaBulan = Barang::selectRaw('MONTH(created_at) as bulan')
      ->groupBy('bulan')
      ->get()
      ->mapWithKeys(function ($item) {
        $bulan = str_pad($item->bulan, 2, '0', STR_PAD_LEFT);
        return [$bulan => $this->getBulanName($bulan)];
      })
      ->all();

    $semuaTahun = Barang::selectRaw('YEAR(created_at) as tahun')
      ->groupBy('tahun')
      ->get();

    return view('apriori.index', compact(['semuaBulan', 'semuaTahun']));
  }

  public function prosesAnalisaApriori(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'bulan' => 'required',
      'tahun' => 'required',
    ]);

    if ($validator->fails()) {
      Alert::error('Proses apriori gagal dilakukan', $validator->errors()->first());
      return back()->withErrors($validator)->withInput();
    }

    $totalPenjualan = Penjualan::count();
    if ($totalPenjualan < 3) {
      Alert::info('Info', 'Data penjualan kurang, silahkan tambahkan data penjualan terlebih dahulu');
      return redirect()->route('dashboard');
    } else {
      $minSupp = $request->min_support;
      $minConfidence = $request->min_confidence;

      // Insert data pengujian
      $kdPengujian =  'KD' . $request->tahun . $request->bulan . str_pad(auth()->user()->id, 4, '0', STR_PAD_LEFT);
      
      Pengujian::updateOrCreate([
        'kode_pengujian' => $kdPengujian,
        'nama_penguji' => $request->nama_penguji,
        'min_support' => $minSupp,
        'min_confidence' => $minConfidence,
      ]);
      Support::where('kode_pengujian', $kdPengujian)->delete();
      NilaiKombinasi::where('kode_pengujian', $kdPengujian)->delete();
      
      $totalHari = Penjualan::select('hari_ke')
        ->whereYear('created_at', $request->tahun)
        ->whereMonth('created_at', $request->bulan)
        ->groupBy('hari_ke')
        ->get()
        ->count();

      // cari nilai support
      $penjualanList = Penjualan::select('barang_id', DB::raw('count(*) as jumlah_transaksi'))
        ->where('no_faktur', '=', 'NF'.$request->tahun.$request->bulan)
        ->groupBy('barang_id')
        ->get();

      foreach ($penjualanList as $penjualan) {
        $nSupport = ($penjualan->jumlah_transaksi / $totalHari) * 100;
        $supp = new Support();
        $supp->kode_pengujian = $kdPengujian;
        $supp->barang_id = $penjualan->barang_id;
        $supp->jumlah_transaksi = $penjualan->jumlah_transaksi;
        $supp->support = $nSupport;
        $supp->save();
      }

      // Kombinasi 2 item set
      $aSupports = Support::where('kode_pengujian', $kdPengujian)->where('support', '>=', $minSupp)->get();
      foreach ($aSupports as $aSupport) {
        $aBarangId = $aSupport->barang_id;
        $bSupports = Support::where('kode_pengujian', $kdPengujian)->where('support', '>=', $minSupp)->get();
        foreach ($bSupports as $bSupport) {
          $bBarangId = $bSupport->barang_id;
          if ($aBarangId != $bBarangId) {
            $kdKombinasi = Str::uuid();
            
            $nk = new NilaiKombinasi();
            $nk->kode_pengujian = $kdPengujian;
            $nk->kode_kombinasi = $kdKombinasi;
            $nk->barang_id_a = $aBarangId;
            $nk->barang_id_b = $bBarangId;

            $aListPenjualan = Penjualan::whereYear('created_at', $request->tahun)
              ->whereMonth('created_at', $request->bulan)
              ->where('barang_id', $aBarangId)
              ->get();
            
            $bListPenjualan = Penjualan::whereYear('created_at', $request->tahun)
              ->whereMonth('created_at', $request->bulan)
              ->where('barang_id', $bBarangId)
              ->get();
            
            $jumlahTransaksi = 0;
            foreach ($aListPenjualan as $aPenjualan) {
              if ($bListPenjualan->where('hari_ke', $aPenjualan->hari_ke)->first()) {
                $jumlahTransaksi += 1;
              }
            }

            $nk->jumlah_transaksi = $jumlahTransaksi;
            $nk->support = ($jumlahTransaksi / $totalHari) * 100;;
            $nk->save();
          }
        }
      }

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
    $totalHari = Penjualan::select('hari_ke')
        ->whereYear('created_at', substr($kdPengujian, 2, 4))
        ->whereMonth('created_at', substr($kdPengujian, 6, 2))
        ->groupBy('hari_ke')
        ->get()
        ->count();

    $polaHasilAnalisa = $dataMinConfidence;
    foreach ($polaHasilAnalisa as $data) {
      $data->confidence = round(($data->jumlah_transaksi / $dataMinSupp->where('barang_id', $data->barang_id_a)->first()->jumlah_transaksi) * 100, 2);
    }

    return view('apriori.hasil', compact('dataPengujian', 'dataSupportBarang', 'dataMinSupp', 'dataKombinasiItemSet', 'dataMinConfidence', 'totalHari'));
  }

  public function cetakAnalisa($kdPengujian)
  {
    $dataPengujian = Pengujian::where('kode_pengujian', $kdPengujian)->first();
    $dataMinConfidence = NilaiKombinasi::where('kode_pengujian', $kdPengujian)->where('support', '>=', $dataPengujian->min_confidence)->get();
    $totalBarang = Barang::count();
    $pdf = PDF::loadView('apriori.cetak', compact('dataPengujian', 'dataMinConfidence', 'totalBarang'));
    return $pdf->stream();
  }

  function getBulanName($bulan)
  {
    $bulanNames = [
      '01' => 'Januari',
      '02' => 'Februari',
      '03' => 'Maret',
      '04' => 'April',
      '05' => 'Mei',
      '06' => 'Juni',
      '07' => 'Juli',
      '08' => 'Agustus',
      '09' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember',
    ];

    return $bulanNames[$bulan] ?? '';
  }

  function countDays($year, $month, $ignore) {
    $count = 0;
    $counter = mktime(0, 0, 0, $month, 1, $year);
    while (date("n", $counter) == $month) {
        if (in_array(date("w", $counter), $ignore) == false) {
            $count++;
        }
        $counter = strtotime("+1 day", $counter);
    }
    return $count;  
  }
}
