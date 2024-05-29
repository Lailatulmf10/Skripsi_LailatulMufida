<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
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

    $semuaKategori = Kategori::query()->paginate(10);
    return view('kategori.index', compact('semuaKategori', 'startingRow'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('kategori.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required',
    ]);

    try {
      Kategori::create($request->all());
      Alert::toast('Kategori berhasil ditambahkan', 'success');
      return redirect()->route('kategori.index');
    } catch (\Throwable $th) {
      return back()->withInput();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Kategori  $kategori
   * @return \Illuminate\Http\Response
   */
  public function show(Kategori $kategori)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Kategori  $kategori
   * @return \Illuminate\Http\Response
   */
  public function edit(Kategori $kategori)
  {
    return view('kategori.edit', compact('kategori'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Kategori  $kategori
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Kategori $kategori)
  {
    $request->validate([
      'nama' => 'required',
    ]);

    try {
      $kategori->update($request->all());
      Alert::toast('Kategori berhasil diubah', 'success');
      return redirect()->route('kategori.index');
    } catch (\Throwable $th) {
      return back()->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Kategori  $kategori
   * @return \Illuminate\Http\Response
   */
  public function destroy(Kategori $kategori)
  {
    try {
      $kategori->delete();
      Alert::toast('Kategori berhasil dihapus', 'success');
      return redirect()->route('kategori.index');
    } catch (\Throwable $th) {
      return back()->withInput();
    }
  }
}
