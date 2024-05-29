<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center gap-2">
      <a href="{{ route('barang.index') }}" class="text-gray-400 hover:text-gray-500">
        <i class="fa-solid fa-arrow-left"></i>
      </a>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Tambah Barang') }}
      </h2>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div
          class="flex flex-col items-start justify-between gap-2 border-b border-gray-200 bg-white px-4 py-3 sm:px-6 lg:flex-row lg:items-center lg:gap-0">
          <div class="flex flex-col">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Form Tambah Barang
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
              Form untuk menambahkan data barang baru
            </p>
          </div>
        </div>
        <form method="POST" action="{{ route('barang.store') }}" class="mx-auto p-4 sm:px-6">
          @csrf
          <div class="mb-5">
            {{-- tanggal input --}}
            <label for="tanggal" class="mb-2 block text-sm font-medium text-gray-900">
              Tanggal Masuk
            </label>
            <input type="date" id="tanggal" name="tanggal"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500"
              required />
          </div>
          <div class="mb-5">
            <label for="name" class="mb-2 block text-sm font-medium text-gray-900">
              Item
            </label>
            <input type="text" id="name" name="nama"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500"
              required />
          </div>
          <div class="mb-5">
            <label for="jumlah" class="mb-2 block text-sm font-medium text-gray-900">
              Jumlah
            </label>
            <input type="number" id="jumlah" name="jumlah" min="50"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500"
              required />
          </div>
          <div class="mb-5">
            <label for="category" class="mb-2 block text-sm font-medium text-gray-900">
              Kategori
            </label>
            <select id="category" name="kategori_id"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500"
              required>
              <option value="" disabled selected>Pilih Kategori</option>
              @foreach ($semuaKategori as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="flex">
            <button type="submit"
              class="ms-auto w-full rounded-lg bg-indigo-700 px-8 py-2.5 text-center text-sm font-medium text-white hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 sm:w-auto">
              Tambah
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
