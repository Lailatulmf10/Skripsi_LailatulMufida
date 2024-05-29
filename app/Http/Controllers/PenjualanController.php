<?php

namespace App\Http\Controllers;

use App\Imports\PenjualanImport;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PenjualanController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $currentPage = request()->input('page') ?? 1; // Get current page
    $perPage = 10; // Items per page (assuming 10)
    $startingRow = ($currentPage - 1) * $perPage; // Calculate starting row

    $selectedMonth = request()->get('filterMonth');

    $dataPenjualan = Penjualan::select('no_faktur', 'created_at')
      ->groupBy('no_faktur', 'created_at')
      ->distinct();

    if ($selectedMonth) {
      $dataPenjualan->whereMonth('created_at', $selectedMonth);
    }

    $dataPenjualan = $dataPenjualan->paginate(10);
    return view('penjualan.index', compact('dataPenjualan', 'startingRow'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
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

    $noFaktur = Str::uuid();
    return view('penjualan.create', compact('semuaBulan', 'semuaTahun', 'noFaktur'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'no_faktur' => 'required',
        'bulan' => 'required',
        'tahun' => 'required',
      ]);

      if ($validator->fails()) {
        Alert::error('Penjualan gagal ditambahkan', $validator->errors()->first());
        return back()->withErrors($validator)->withInput();
      }
      $barang = Barang::where('created_at', 'like', '%' . $request->tahun . '-' . $request->bulan . '%')->get();

      foreach ($barang as $item) {
        Penjualan::create([
          'no_faktur' => $request->no_faktur,
          'barang_id' => $item->id,
          'qty' => $item->jumlah,
        ]);
      }
      Alert::toast('Penjualan berhasil ditambahkan', 'success');
      return redirect()->route('penjualan.index');
    } catch (\Throwable $th) {
      Alert::error('Penjualan gagal ditambahkan', $th->getMessage());
      return back()->withInput();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Penjualan  $penjualan
   * @return \Illuminate\Http\Response
   */
  public function show($penjualan)
  {
    $penjualan = Penjualan::where('no_faktur', $penjualan)->get();
    $no_faktur = $penjualan->first()->no_faktur;
    $semuaBarang = Barang::all();
    return view('penjualan.show', compact('penjualan', 'semuaBarang', 'no_faktur'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Penjualan  $penjualan
   * @return \Illuminate\Http\Response
   */
  public function edit(Penjualan $penjualan)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Penjualan  $penjualan
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Penjualan $penjualan)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Penjualan  $penjualan
   * @return \Illuminate\Http\Response
   */
  public function destroy(Penjualan $penjualan)
  {
    //
  }

  public function import(Request $request)
  {
    if (!$request->hasFile('file')) {
      Alert::error("File tidak ditemukan", "Terjadi kesalahan");
      return back();
    }
    $request->validate([
      'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
      $file = $request->file('file');
      $namaFile = time() . '.' . $file->getClientOriginalExtension();
      //temporary file
      $path = $file->storeAs('public/excel/', $namaFile);

      $import = Excel::import(new PenjualanImport(), storage_path('app/public/excel/' . $namaFile));
      Storage::delete($path);
      if (!$import) {
        throw new \Exception("Gagal mengimport data Penjualan");
      }
      Alert::toast('Data Penjualan berhasil diimport', 'success');
      return redirect()->route('penjualan.index');
    } catch (\Throwable $th) {
      Alert::error("Gagal mengimport data Penjualan", $th->getMessage());
      return back();
    }
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
}
