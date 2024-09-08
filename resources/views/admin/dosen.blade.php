<x-app-layout>
    <x-slot name="header">
        {{ __('Dosen') }}
    </x-slot>

    <style>
        body {
            background-color: #F9FAFB;
        }
    </style>

        @include('components.toast')
    <div class="w-full pt-4 px-2 sm:px-4 md:px-10 lg:ps-80 mx-auto">

        <div class="p-4 bg-white rounded-lg shadow-md">
            <div class="p-4 bg-gray-50 flex flex-col border border-dashed border-gray-200 rounded-xl overflow-auto">
                
            <!-- Header -->
            <div class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-4 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
                <div class="sm:col-span-12 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Informasi distribusi dosen
                        </h2>
                        <p class="text-sm text-gray-600">
                            Membimbing dan menguji
                        </p>
                    </div>
                    <div class="py-3 flex justify-end">
                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-scale-animation-modal" data-hs-overlay="#hs-scale-animation-modal">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            Tambah
                        </button>
                    </div>
                </div>
                
            </div>
                
            <!-- End Header -->

            <div class="py-3 border-t border-gray-200"></div>
                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100 shadow">
                        <tr>
                            </th>
                            <th scope="col" class="ps-6 lg:ps-3 xl:ps-2 pe-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                        NIP
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                        NIDN
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                        Nama Dosen
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                        No. Telp
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-3 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                        
                                    </span>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @if($dosen->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <span class="text-sm text-gray-500">Tidak ada data dosen yang tersedia.</span>
                            </td>
                        </tr>
                        @else
                        @foreach($dosen as $row)
                        <tr>
                            <td class="size-px whitespace-nowrap">
                                <div class="ps-6 lg:ps-3 xl:ps-2 pe-6 py-3">
                                    <div class="flex items-center gap-x-3">
                                        <div class="grow">
                                            <span class="block text-sm text-gray-500">{{ $row->NIP}}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap ">
                                <div class="px-6 py-3">
                                    <span class="block text-sm text-gray-500">{{ $row->NIDN}}</span>
                                </div>
                            </td>
                            <td class="h-px w-72 whitespace-nowrap">
                                <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                    <div class="flex items-center gap-x-3">
                                        <div class="grow">
                                            <span class="block text-sm text-gray-500">{{ $row->nama_dosen}}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div class="px-6 py-3">
                                    <div class="grow">
                                        <span class="block text-sm text-gray-500">{{ $row->no_telp}}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="size-px whitespace-nowrap">
                                <div class="px-3 py-1.5">
                                    <div class="inline-flex rounded-lg shadow-sm space-x-2">
                                        <a href="{{ route('admin.dosen.detail', $row->NIP) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-yellow-500 text-white hover:bg-yellow-600 focus:outline-none focus:bg-yellow-600 disabled:opacity-50 disabled:pointer-events-none">
                                            Edit
                                        </a>
                                        <form id="deleteForm" action="{{ route('admin.dosen.delete', '') }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="delete-btn py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:bg-red-600 disabled:opacity-50 disabled:pointer-events-none" data-id="{{ $row->NIP }}">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <!-- End Table -->
                
            </div>
        </div>
    </div>
    <!-- End Stepper -->
    <div id="hs-scale-animation-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-scale-animation-modal-label">
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] md:max-w-2xl md:w-full m-3 md:mx-auto flex items-center">
            <div class="w-full flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <h3 id="hs-scale-animation-modal-label" class="font-bold text-gray-800 dark:text-white">
                        Tambah Dosen
                    </h3>
                    <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-scale-animation-modal">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto">
                    <form>
                    <div class="space-y-3 mx-6">
                        <div class="max-w-sm space-y-3">
                            <div>
                                <label for="hs-leading-icon" class="block text-sm font-medium mb-2 dark:text-white">NIP</label>
                                <div class="relative">
                                    <input type="text" id="nip" name="nip" class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter...">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                        <svg class="shrink-0 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="max-w-sm space-y-3">
                            <div>
                                <label for="hs-leading-icon" class="block text-sm font-medium mb-2 dark:text-white">NIDN</label>
                                <div class="relative">
                                    <input type="text" id="nidn" name="nidn" class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter...">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                        <svg class="shrink-0 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="max-w-sm space-y-3">
                            <div>
                                <label for="hs-leading-icon" class="block text-sm font-medium mb-2 dark:text-white">Nama Dosen</label>
                                <div class="relative">
                                    <input type="text" id="nama-dosen" name="nama-dosen" class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter...">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                        <svg class="shrink-0 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="max-w-sm space-y-3">
                            <div>
                                <label for="hs-leading-icon" class="block text-sm font-medium mb-2 dark:text-white">No. Telp</label>
                                <div class="relative">
                                    <input type="text" id="no-telp" name="no-telp" class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter...">
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                        <svg class="shrink-0 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#hs-scale-animation-modal">
                    Close
                    </button>
                    <button type="button" id="save-btn" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteConfirmationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-1/4 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Konfirmasi Penghapusan
                </h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700">
                        Hapus
                    </button>
                    <button id="cancelDeleteBtn" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 mt-2">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const saveBtn = document.querySelector('#save-btn');
            // const deleteButtons = document.querySelectorAll('form button[type="submit"]');

            saveBtn.addEventListener('click', function () {
                const nip = document.getElementById('nip').value;
                const nidn = document.getElementById('nidn').value;
                const namaDosen = document.getElementById('nama-dosen').value;
                const nomorTelp = document.getElementById('no-telp').value;

                const formData = new FormData();
                formData.append('NIP', nip);
                formData.append('NIDN', nidn);
                formData.append('nama_dosen', namaDosen);
                formData.append('no_telp', nomorTelp);

                fetch('{{ route('tambah.dosen') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Data berhasil disimpan!', false);
                        location.reload();
                    } else {
                        showToast('Terjadi kesalahan saat menyimpan data.', false);
                    }
                })
                .catch(error => {
                    showToast('Terjadi kesalahan saat menyimpan data.', false);
                    console.error('Error:', error);
                });
                const modal = document.getElementById('hs-scale-animation-modal');
                const backdrop = document.getElementById('hs-scale-animation-modal-backdrop');
                modal.classList.add('hidden');
                backdrop.classList.add('hidden');
            });
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteForm = document.getElementById('deleteForm');
            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

            let deleteId = '';

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    deleteId = this.getAttribute('data-id');
                    deleteConfirmationModal.classList.remove('hidden');
                });
            });

            confirmDeleteBtn.addEventListener('click', function () {
                deleteForm.action = `{{ route('admin.dosen.delete', '') }}/${deleteId}`;
                deleteForm.submit();
            });

            cancelDeleteBtn.addEventListener('click', function () {
                deleteConfirmationModal.classList.add('hidden');
                deleteId = '';
            });
        })
    </script>
</x-app-layout>
