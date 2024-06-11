<?php

namespace App\Http\Controllers;

use App\Imports\BarangImport;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
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

    $semuaBarang = Barang::query()->paginate(10);
    $month = Barang::selectRaw('MONTH(created_at) as month')->distinct()->get();
    $semuaKategori = Kategori::all();
    return view('barang.index', compact('semuaBarang', 'semuaKategori', 'startingRow'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $semuaKategori = Kategori::all();
    return view('barang.create', compact('semuaKategori'));
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
        'nama' => 'required',
        'kategori_id' => 'required|exists:kategori,id',
        'jumlah' => 'required|numeric',
        'tanggal' => 'required|date',
      ]);

      if ($validator->fails()) {
        Alert::error($validator->errors()->first(), "Terjadi kesalahan");
        return back()->withInput();
      }

      Barang::create([
        'nama' => $request->nama,
        'kategori_id' => $request->kategori_id,
        'jumlah' => $request->jumlah,
        'jumlah_transaksi' => $request->jumlah_transaksi,
        'harga' => $request->harga,
        'created_at' => $request->tanggal,
      ]);
      Alert::toast('Barang berhasil ditambahkan', 'success');
      return redirect()->route('barang.index');
    } catch (\Throwable $th) {
      Alert::error("Gagal menambahkan barang", "Terjadi kesalahan");
      return back()->withInput();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Barang  $barang
   * @return \Illuminate\Http\Response
   */
  public function show(Barang $barang)
  {
    $barang = Barang::query()->find($barang->id);
    if (!$barang) {
      return response()->json(['message' => 'Barang tidak ditemukan'], 404);
    }
    return response()->json($barang);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Barang  $barang
   * @return \Illuminate\Http\Response
   */
  public function edit(Barang $barang)
  {
    $barang = Barang::query()->find($barang->id);
    $semuaKategori = Kategori::all();
    $barang->tanggal = $barang->created_at->format('Y-m');
    return view('barang.edit', compact('barang', 'semuaKategori'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Barang  $barang
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Barang $barang)
  {
    try {
      $validator = Validator::make($request->all(), [
        'nama' => 'required',
        'kategori_id' => 'required|exists:kategori,id',
        'jumlah' => 'required|numeric',
        'tanggal' => 'required|date',
      ]);

      if ($validator->fails()) {
        Alert::error($validator->errors()->first(), "Terjadi kesalahan");
        return back()->withInput();
      }

      $barang->update([
        'nama' => $request->nama,
        'kategori_id' => $request->kategori_id,
        'jumlah' => $request->jumlah,
        'jumlah_transaksi' => $request->jumlah_transaksi,
        'harga' => $request->harga,
        'created_at' => $request->tanggal,
      ]);
      Alert::toast('Barang berhasil diubah', 'success');
      return redirect()->route('barang.index');
    } catch (\Throwable $th) {
      Alert::error("Gagal mengubah barang", "Terjadi kesalahan");
      return back()->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Barang  $barang
   * @return \Illuminate\Http\Response
   */
  public function destroy(Barang $barang)
  {
    try {
      $barang->delete();
      Alert::toast('Barang berhasil dihapus', 'success');
      return redirect()->route('barang.index');
    } catch (\Throwable $th) {
      Alert::error("Gagal menghapus barang", "Terjadi kesalahan");
      return back();
    }
  }

  public function import(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:xlsx,xls',
    ]);

    if (!$request->hasFile('file')) {
      Alert::error("File tidak ditemukan", "Terjadi kesalahan");
      return back();
    }

    try {
      $file = $request->file('file');
      $namaFile = time() . '.' . $file->getClientOriginalExtension();
      //temporary file
      $path = $file->storeAs('public/excel/', $namaFile);

      $import = Excel::import(new BarangImport(), storage_path('app/public/excel/' . $namaFile));
      Storage::delete($path);
      if (!$import) {
        throw new \Exception("Gagal mengimport data barang");
      }
      Alert::toast('Data barang berhasil diimport', 'success');
      return redirect()->route('barang.index');
    } catch (\Throwable $th) {
      Alert::error("Gagal mengimport data barang", $th->getMessage());
      return back();
    }
  }
}
