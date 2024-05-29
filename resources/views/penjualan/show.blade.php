<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center gap-2">
      <a href="{{ route('penjualan.index') }}" class="text-gray-400 hover:text-gray-500">
        <i class="fa-solid fa-arrow-left"></i>
      </a>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Detail Data Penjualan') }}
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
              Detail Data Penjualan
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
              Detail data penjualan dengan no faktur: <b>{{ $no_faktur }}</b>
            </p>
          </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Nama Produk</th>
                <th scope="col" class="px-6 py-3">Qty</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($penjualan as $data)
                <tr class="border-b bg-white hover:bg-gray-50">
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $loop->iteration }}
                  </th>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $data->dataBarang($data->id)->nama }}
                  </th>
                  <td class="max-w-lg px-6 py-4">
                    <span class="line-clamp-2">
                      {{ $data->qty }}
                    </span>
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
