<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Proses Apriori') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div
          class="flex flex-col items-start justify-between gap-2 border-b border-gray-200 bg-white px-4 py-3 sm:px-6 lg:flex-row lg:items-center lg:gap-0">
          <div class="flex flex-col">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Form Proses Apriori
            </h3>
            <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
              Setup nilai support & confidence
            </p>
          </div>
        </div>
        <form method="POST" action="{{ route('apriori.proses') }}" class="mx-auto p-4 sm:px-6">
          @csrf
          <div class="mb-5">
            <label for="nama_penguji" class="mb-2 block text-sm font-medium text-gray-900">
              Nama Penguji
            </label>
            <input type="text" id="nama_penguji" name="nama_penguji"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500"
              required />
          </div>
          <div class="mb-5">
            <label for="min_support" class="mb-2 block text-sm font-medium text-gray-900">
              Nilai Support <b class="text-xs text-red-400">
                *Semakin rendah nilai support akan semakin
                banyak proses yang
                mengakibatkan proses apriori menjadi lama
              </b>
            </label>
            <input type="number" id="min_support" name="min_support" min="1" max="100"
              step="0.01"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500"
              required />
          </div>
          <div class="mb-5">
            <label for="min_confidence" class="mb-2 block text-sm font-medium text-gray-900">
              Nilai Confidence
            </label>
            <input type="number" id="min_confidence" name="min_confidence" min="1" max="100"
              step="0.01"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500"
              required />
          </div>
          <div class="flex">
            <button type="submit" id="submit-button"
              class="me-auto w-full rounded-lg bg-indigo-700 px-8 py-2.5 text-center text-sm font-medium text-white hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 sm:w-auto">
              Mulai Analisa Penjualan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      $('#submit-button').click(function(e) {
        e.preventDefault();
        $(this).prop('disabled', true);

        Swal.fire({
          title: 'Konfirmasi Analisa Penjualan',
          text: "Apakah Anda yakin ingin memulai Analisa Penjualan?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Analisa Sekarang!'
        }).then((result) => {
          if (result.isConfirmed) {
            $(this).closest('form').submit();
          } else {
            $(this).prop('disabled', false);
          }
        });
      });
    });
  </script>

</x-app-layout>
