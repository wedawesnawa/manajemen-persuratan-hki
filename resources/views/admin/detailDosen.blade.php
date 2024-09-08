<x-app-layout>
    <x-slot name="header">
        {{ __('Pengajuan') }}
    </x-slot>

    <style>
        body {
            background-color: #F9FAFB;
        }
    </style>

    @include('components.toast')
    <div class="w-full pt-4 px-2 sm:px-4 md:px-10 lg:ps-80 mx-auto">

        <div class="p-2 bg-white rounded-lg shadow-md">
            <div class="p-4 bg-gray-50 flex flex-col border border-dashed border-gray-200 rounded-xl overflow-auto">

                <!-- Header -->
                <div
                    class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-4 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
                    <div class="sm:col-span-12">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Mahasiswa
                        </h2>
                        <p class="text-sm text-gray-600">
                            Tambah,kelola dan unggah pengumuman
                        </p>
                    </div>
                </div>
                <!-- End Header -->

                <div class="py-3 border-t border-gray-200"></div>
                <!-- Card Section -->
                <div class="space-y-4">
                    <div class="sm:col-span-12 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div>
                                <label for="hs-leading-icon" class="block text-sm font-medium mb-2 dark:text-white">NIP</label>
                                <div class="relative">
                                    <div class="mt-4 flex items-center justify-start px-4 text-xs font-medium bg-gray-100 text-gray-800 rounded-none text-left w-full">
                                        <div class="my-3 text-sm font-medium-light text-blue-500 flex items-center">
                                            {{ $dosen->NIP }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label for="hs-leading-icon" class="block text-sm font-medium mb-2 dark:text-white">NIDN</label>
                                <div class="relative">
                                    <input type="text" id="nidn" name="nidn" class="py-3 mt-4 block w-full bg-gray-100 border-gray-100 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter..." value="{{ $dosen->NIDN }}"> 
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label for="hs-leading-icon" class="block text-sm font-medium mb-2 dark:text-white">Nama Dosen</label>
                                <div class="relative">
                                    <input type="text" id="nama" name="nama" class="py-3 mt-4 block w-full bg-gray-100 border-gray-100 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter..." value="{{ $dosen->nama_dosen }}"> 
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label for="hs-leading-icon" class="block text-sm font-medium mb-2 dark:text-white">No. Telp</label>
                                <div class="relative">
                                    <input type="text" id="telp" name="telp" class="py-3 mt-4 block w-full bg-gray-100 border-gray-100 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter..." value="{{ $dosen->no_telp }}"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
            <!-- End Grid -->

            <div class="mt-5 flex justify-between">
                <button type="button" onclick="window.location.href = '/admin/dosen'"
                    class="py-2 px-10 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-500 text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 disabled:opacity-50 disabled:pointer-events-none">
                    Back
                </button>
                <button type="button" id="save-btn"
                    class="py-2 px-10 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Save Changes
                </button>
            </div>
        </div>

        <!-- End Card -->

        <!-- End Card Section -->
    </div>
    <!-- </div> -->
    <div id="confirmation-toast" class="fixed inset-0 flex items-center justify-center bg-opacity-50 bg-gray-800 hidden z-50" role="alert" tabindex="-1" aria-labelledby="hs-toast-with-icons-label">
        <div class="max-w-md bg-teal-50 border border-teal-200 rounded-xl shadow-lg">
            <div class="flex p-4">
                <div class="shrink-0">
                    <svg class="size-5 text-gray-600 mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                    </svg>
                </div>
                <div class="ms-4">
                    <h3 id="hs-toast-with-icons-label" class="text-gray-800 font-semibold">
                        Confirm Submission
                    </h3>
                    <div class="mt-1 text-sm text-gray-600">
                        Are you sure you want to submit the form? Your changes will be saved.
                    </div>
                    <div class="mt-4">
                        <div class="flex gap-x-3">
                            <button id="cancel-btn" type="button" class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-none focus:underline">
                                Cancel
                            </button>
                            <button id="confirm-btn" type="button" class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-none focus:underline">
                                Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () { 
            const saveBtn = document.querySelector('#save-btn');


            saveBtn.addEventListener('click', function () {
                showToastConfirm('Are you sure you want to submit the form? Your changes will be saved.', true);
            });

            function showToastConfirm(message, showConfirmation = false) {
                const toast = document.getElementById('confirmation-toast');
                const toastMessage = toast.querySelector('div.text-sm');

                toastMessage.textContent = message;
                toast.classList.remove('hidden');

                if (showConfirmation) {
                    document.getElementById('cancel-btn').addEventListener('click', function () {
                        toast.classList.add('hidden'); 
                    });

                    document.getElementById('confirm-btn').addEventListener('click', function () {
                        toast.classList.add('hidden'); 
                        handleFinish(); 
                    });
                } else {
                    toast.classList.add('hidden');
                }
            }
            function handleFinish() {
                const nidn = document.getElementById('nidn').value;
                const namaDosen = document.getElementById('nama').value;
                const telp = document.getElementById('telp').value;
            
                const nip = '{{ $dosen->NIP }}'; // Assuming this variable is available in the Blade view

                const formData = new FormData();
                formData.append('NIP', nip);
                formData.append('NIDN', nidn);
                formData.append('nama_dosen', namaDosen);
                formData.append('no_telp', telp);

                fetch('{{ route('edit.dosen') }}', {
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
                    } else {
                        showToast('Terjadi kesalahan saat menyimpan data.', false);
                    }
                })
                .catch(error => {
                    showToast('Terjadi kesalahan saat menyimpan data.', false);
                    console.error('Error:', error);
                });
            }
        })
    </script>
</x-app-layout>
