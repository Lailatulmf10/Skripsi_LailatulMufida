<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Penjualan') }}
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
              Data Penjualan
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
              Rangkuman data penjualan yang tersedia
            </p>
          </div>
          <div class="flex items-center">
            <a href="{{ route('penjualan.create') }}" class="no-underline">
              <button type="button"
                class="focus:shadow-outline-blue inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out hover:bg-indigo-500 focus:border-blue-700 focus:outline-none active:bg-blue-700">
                <i class="fa-solid fa-circle-plus -ml-1 mr-2 text-lg"></i>
                <span>Tambah Data Penjualan</span>
              </button>
            </a>
          </div>
        </div>
        <form
          class="flex flex-col items-start justify-between gap-2 border-b border-gray-200 bg-white px-4 py-3 sm:px-6 lg:flex-row lg:items-center lg:gap-0"
          method="GET">
          <div class="relative">
            <select name="filterMonth"
              class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-3 pr-10 py-2 text-left sm:text-sm">
              <option value="">Semua Bulan</option>
              <option value="1">Januari</option>
              <option value="2">Februari</option>
              <option value="3">Maret</option>
              <option value="4">April</option>
              <option value="5">Mei</option>
              <option value="6">Juni</option>
              <option value="7">Juli</option>
              <option value="8">Agustus</option>
              <option value="9">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select>
          </div>
          <button type="submit"
            class="focus:shadow-outline-blue inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out hover:bg-indigo-500 focus:border-blue-700 focus:outline-none active:bg-blue-700">
            Filter
          </button>
        </form>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">No Faktur</th>
                <th scope="col" class="px-6 py-3">Tanggal Transaksi</th>
                <th scope="col" class="px-6 py-3">Total Qt</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dataPenjualan as $penjualan)
                <tr class="border-b bg-white hover:bg-gray-50">
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $startingRow + $loop->iteration }}
                  </th>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $penjualan->no_faktur }}
                  </th>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $penjualan->created_at }}
                  </th>
                  <td class="max-w-lg px-6 py-4">
                    <span class="line-clamp-2">
                      {{ $penjualan->hitungTotalQt($penjualan->no_faktur) }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <a href="{{ route('penjualan.show', $penjualan->no_faktur) }}" class="no-underline">
                      <button type="button"
                        class="focus:shadow-outline-indigo inline-flex items-center rounded-md border border-transparent bg-indigo-600 p-2 text-center font-medium leading-4 text-white transition duration-150 ease-in-out hover:bg-indigo-500 focus:border-indigo-700 focus:outline-none active:bg-indigo-700">
                        <i class="fa-solid fa-eye"></i>
                      </button>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <nav class="p-4 border-t" aria-label="Table navigation">
            {{ $dataPenjualan->links() }}
          </nav>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
