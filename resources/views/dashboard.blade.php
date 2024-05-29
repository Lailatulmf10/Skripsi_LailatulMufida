<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="flex flex-col gap-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <section class="flex flex-wrap gap-5">
        <div class="p-4 max-w-72 grow bg-white rounded-lg flex flex-col gap-8">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Total Transaksi</h2>
            <i class="fa-solid text-indigo-600 text-xl fa-money-bill-transfer"></i>
          </div>
          <p class="text-xl font-semibold text-gray-800">{{ $totalPenjualan }}</p>
        </div>
        <div class="p-4 max-w-72 grow bg-white rounded-lg flex flex-col gap-8">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Total Barang</h2>
            <i class="fa-solid text-indigo-600 text-xl fa-box"></i>
          </div>
          <p class="text-xl font-semibold text-gray-800">{{ $totalBarang }}</p>
        </div>
        <div class="p-4 max-w-72 grow bg-white rounded-lg flex flex-col gap-8">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Avg. Jumlah Produk</h2>
            <i class="fa-solid text-indigo-600 text-xl fa-tags"></i>
          </div>
          <p class="text-xl font-semibold text-gray-800">{{ $average }}</p>
        </div>
        <div class="p-4 max-w-72 grow bg-white rounded-lg flex flex-col gap-8">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Total User</h2>
            <i class="fa-solid text-indigo-600 text-xl fa-users"></i>
          </div>
          <p class="text-xl font-semibold text-gray-800">{{ $totalUser }}</p>
        </div>
      </section>
      <section class="relative overflow-x-auto bg-white p-5 shadow-md sm:rounded-lg">
        <h1 class="text-xl font-semibold text-gray-800 mb-5">Transaksi Terakhir</h1>
        <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
          <thead class="bg-gray-50 text-xs uppercase text-gray-700">
            <tr>
              <th scope="col" class="px-6 py-3">No</th>
              <th scope="col" class="px-6 py-3">No Faktur</th>
              <th scope="col" class="px-6 py-3">Waktu Transaksi</th>
              <th scope="col" class="px-6 py-3">Total Produk</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transaksiTerakhir as $transaksi)
              <tr class="border-b bg-white hover:bg-gray-50">
                <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                  {{ $loop->iteration }}
                </th>
                <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                  {{ $transaksi->no_faktur }}
                </th>
                <td class="max-w-lg px-6 py-4">
                  <span class="text-sm font-medium text-gray-900">
                    {{ $transaksi->created_at->diffForHumans() }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  <span class="text-sm font-medium text-gray-900">
                    {{ $transaksi->hitungTotalQt($transaksi->no_faktur) }}
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </section>
    </div>
  </div>
</x-app-layout>
