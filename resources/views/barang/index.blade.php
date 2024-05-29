<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Barang') }}
      </h2>
      <!-- Modal toggle -->
      <button data-modal-target="modal-import" data-modal-toggle="modal-import"
        class="focus:shadow-outline-blue inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out hover:bg-indigo-500 focus:border-blue-700 focus:outline-none active:bg-blue-700"
        type="button">
        Import Data Barang
      </button>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div
          class="flex flex-col items-start justify-between gap-2 border-b border-gray-200 bg-white px-4 py-3 sm:px-6 lg:flex-row lg:items-center lg:gap-0">
          <div class="flex flex-col">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Data Barang
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
              Rangkuman data barang yang tersedia
            </p>
          </div>
          <div class="flex items-center">
            <a href="{{ route('barang.create') }}" class="no-underline">
              <button type="button"
                class="focus:shadow-outline-blue inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out hover:bg-indigo-500 focus:border-blue-700 focus:outline-none active:bg-blue-700">
                <i class="fa-solid fa-circle-plus -ml-1 mr-2 text-lg"></i>
                <span>Tambah Barang</span>
              </button>
            </a>
          </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-left text-sm text-gray-500 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Kategori</th>
                <th scope="col" class="px-6 py-3">Item</th>
                <th scope="col" class="px-6 py-3">Jumlah</th>
                <th scope="col" class="px-6 py-3">Tanggal Masuk</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($semuaBarang as $barang)
                <tr class="border-b bg-white hover:bg-gray-50">
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $startingRow + $loop->iteration }}
                  </th>
                  <td class="px-6 py-4">
                    <span class="text-sm font-medium text-gray-900">
                      {{ $barang->kategori->nama }}
                    </span>
                  </td>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $barang->nama }}
                  </th>
                  <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                    {{ $barang->jumlah }}
                  </th>
                  <td class="px-6 py-4">
                    <span class="text-sm font-medium text-gray-900">
                      {{ $barang->created_at->format('d F Y') }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <a href="{{ route('barang.edit', $barang->id) }}" class="no-underline">
                      <button type="button"
                        class="focus:shadow-outline-blue inline-flex items-center rounded-md border border-transparent bg-blue-600 p-2 text-center font-medium leading-4 text-white transition duration-150 ease-in-out hover:bg-blue-500 focus:border-blue-700 focus:outline-none active:bg-blue-700">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                    </a>
                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="inline-block">
                      @csrf
                      @method('DELETE')
                      <button type="submit" data-toggle="tooltip" title="Delete"
                        class="show_confirm focus:shadow-outline-red inline-flex items-center rounded-md border border-transparent bg-red-600 p-2 text-center font-medium leading-4 text-white transition duration-150 ease-in-out hover:bg-red-500 focus:border-red-700 focus:outline-none active:bg-red-700">
                        <i class="fa-solid fa-trash-can"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <nav class="p-4 border-t" aria-label="Table navigation">
            {{ $semuaBarang->links() }}
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Main modal -->
  <div id="modal-import" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <form method="POST" action="{{ route('barang.import') }}" enctype="multipart/form-data"
        class="relative bg-white rounded-lg shadow">
        @csrf
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Import Data Barang
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="modal-import">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
          <div class="flex flex-col gap-1">
            <label class="block mb-2 text-sm font-medium text-gray-900" for="file">Upload file</label>
            <input
              class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
              id="file" name="file" type="file">
          </div>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
          <button type="submit"
            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Import
          </button>
          <button data-modal-hide="modal-import" type="button"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
            Tutup
          </button>
        </div>
      </form>
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
