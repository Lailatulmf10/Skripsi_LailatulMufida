<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Laporan Analisa') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div
          class="flex flex-col items-start justify-between gap-2 border-b border-gray-200 bg-white px-4 py-3 sm:px-6 lg:flex-row lg:items-center lg:gap-0">
          <div class="flex flex-col">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Data Laporan Analisa
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
              Rangkuman analisa data penjualan yang ada di toko.
            </p>
          </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Kode Pengujian</th>
                <th scope="col" class="px-6 py-3">Nama Penguji</th>
                <th scope="col" class="px-6 py-3">Tanggal Pengujian</th>
                <th scope="col" class="px-6 py-3">Support</th>
                <th scope="col" class="px-6 py-3">Confidence</th>
                <th scope="col" class="px-6 py-3">Total Pola Produk</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dataPengujian as $pengujian)
                <tr class="border-b bg-white hover:bg-gray-50">
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $loop->iteration }}
                  </th>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $pengujian->kode_pengujian }}
                  </th>
                  <td class="whitespace-nowrap px-6 py-4">
                    {{ $pengujian->nama_penguji }}
                  </td>
                  <td class="whitespace-nowrap px-6 py-4">
                    {{ $pengujian->created_at }}
                  </td>
                  <td class="whitespace-normal px-6 py-4">
                    {{ $pengujian->min_support }}
                  </td>
                  <td class="whitespace-normal px-6 py-4">
                    {{ $pengujian->min_confidence }}
                  </td>
                  <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $pengujian->totalPolaProduk($pengujian->kode_pengujian, $pengujian->min_confidence) }}
                  </td>
                  <td class="px-6 py-4">
                    <a href="{{ route('apriori.show', $pengujian->kode_pengujian) }}" class="no-underline">
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
            {{ $dataPengujian->links() }}
          </nav>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $('.show_confirm').click(function(event) {
      const form = $(this).closest('form');
      const name = $(this).data('name');
      event.preventDefault();
      swal({
        title: `Apakah Anda yakin ingin menghapus data ini?`,
        icon: 'warning',
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          form.submit();
        }
      });
    });
  </script>
</x-app-layout>
