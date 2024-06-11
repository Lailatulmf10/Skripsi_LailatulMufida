<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Hasil Analisa Apriori') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div
          class="flex flex-col items-start justify-between gap-2 border-b border-gray-200 bg-white px-4 py-3 sm:px-6 lg:flex-row lg:items-center lg:gap-0">
          <div class="flex flex-col">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Data Support Produk
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
              Rangkuman data support produk
            </p>
          </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Nama Barang</th>
                <th scope="col" class="px-6 py-3">Total Transaksi</th>
                <th scope="col" class="px-6 py-3">Perhitungan Support</th>
                <th scope="col" class="px-6 py-3">Support</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dataSupportBarang as $supp)
                <tr class="border-b bg-white hover:bg-gray-50">
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $loop->iteration }}
                  </th>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $supp->dataBarang($supp->barang_id)->nama }}
                  </th>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $supp->totalTransaksi($supp->barang_id) }}
                  </td>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    ({{ $supp->totalTransaksi($supp->barang_id) }} / {{ $totalHari }})
                    * 100
                  </td>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $supp->support }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <nav class="p-4 border-t" aria-label="Table navigation">
            <p class="font-semibold">Item yang memenuhi syarat minimun support
              {{ $dataPengujian->min_support }} %</p>
          </nav>
          <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Nama Barang</th>
                <th scope="col" class="px-6 py-3">Support</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dataMinSupp as $minSupp)
                <tr class="border-b bg-white hover:bg-gray-50">
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $loop->iteration }}
                  </th>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $minSupp->dataBarang($minSupp->barang_id)->nama }}
                  </th>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $minSupp->support }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <nav class="p-4 border-t" aria-label="Table navigation">
            <p class="font-semibold">Kombinasi 2 itemset</p>
          </nav>
          <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Barang A</th>
                <th scope="col" class="px-6 py-3">Barang B</th>
                <th scope="col" class="px-6 py-3">Jumlah Transaksi</th>
                <th scope="col" class="px-6 py-3">Perhitungan Support</th>
                <th scope="col" class="px-6 py-3">Support</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dataKombinasiItemSet as $itemSet)
                <tr class="border-b bg-white hover:bg-gray-50">
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $loop->iteration }}
                  </th>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $itemSet->dataBarang($itemSet->barang_id_a)->nama }}
                  </th>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $itemSet->dataBarang($itemSet->barang_id_b)->nama }}
                  </th>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $itemSet->jumlah_transaksi }}
                  </td>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    ({{ $itemSet->jumlah_transaksi }} / {{ $totalHari }})
                    * 100
                  </td>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $itemSet->support }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <nav class="p-4 border-t" aria-label="Table navigation">
            <p class="font-semibold">Kombinasi yang memenuhi minimum confidence >
              {{ $dataPengujian->min_confidence }}%</p>
          </nav>
          <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Barang A</th>
                <th scope="col" class="px-6 py-3">Barang B</th>
                <th scope="col" class="px-6 py-3">Jumlah Transaksi</th>
                <th scope="col" class="px-6 py-3">Perhitungan Support</th>
                <th scope="col" class="px-6 py-3">Support</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dataMinConfidence as $itemSet)
                <tr class="border-b bg-white hover:bg-gray-50">
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $loop->iteration }}
                  </th>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $itemSet->dataBarang($itemSet->barang_id_a)->nama }}
                  </td>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $itemSet->dataBarang($itemSet->barang_id_b)->nama }}
                  </td>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $itemSet->jumlah_transaksi }}
                  </td>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    ({{ $itemSet->jumlah_transaksi }} / {{ $totalHari }})
                    * 100
                  </td>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $itemSet->support }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <nav class="p-4 border-t" aria-label="Table navigation">
            <p class="font-semibold">Pola hasil analisa</p>
          </nav>
          <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Pola</th>
                <th scope="col" class="px-6 py-3">Confidence</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dataMinConfidence as $item)
                <tr class="border-b bg-white hover:bg-gray-50">
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $loop->iteration }}
                  </th>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    Apabila pelanggan membeli {{ $item->dataBarang($item->barang_id_a)->nama }}, maka
                    pelanggan juga akan membeli {{ $item->dataBarang($item->barang_id_b)->nama }}
                  </td>
                  <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $item->confidence }} %
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
