<x-app-layout>
    <x-slot name="header">
        {{ __('Pengajuan') }}
    </x-slot>

    <!-- Background -->
    <style>
        body {
            background-color: #F9FAFB;
        }
    </style>
    @include('components.toast')
    <!-- Toast Notification -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast("{{ session('success') }}", 'success');
            });
        </script>
    @elseif(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast("{{ session('error') }}", 'error');
            });
        </script>
    @endif
    <div class="w-full pt-4 px-2 sm:px-4 md:px-10 lg:ps-80 mx-auto">

        <div class="p-4 bg-white rounded-lg shadow-md">
            <div class="p-4 bg-gray-50 flex flex-col border border-dashed border-gray-200 rounded-xl overflow-auto">
                
                <!-- Header -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-4 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
                    <div class="sm:col-span-12">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Beranda
                        </h2>
                        <p class="text-sm text-gray-600">
                            Detail Beranda
                        </p>
                    </div>
                </div>
                <!-- End Header -->

                <div class="py-3 border-t border-gray-200"></div>

                <form action="{{ route('admin.beranda.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-3 mx-6 my-6">
                        <div class="space-y-3">
                            <div>
                                <label for="title" class="block text-sm font-medium mb-2 dark:text-white">Headline</label>
                                <input type="text" id="title" name="title" class="py-3 px-4 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter..." value="{{ $beranda->title }}">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label for="body" class="block text-sm font-medium mb-2 dark:text-white">Deskripsi</label>
                                <!-- Memperbaiki textarea untuk menampilkan nilai -->
                                <textarea id="body" name="body" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="This is a textarea placeholder">{{ $beranda->body }}</textarea>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label for="file" class="block text-sm font-medium mb-2 dark:text-white">File Upload</label>
                                
                                <!-- Cek jika ada file -->
                                @if ($beranda->file)
                                    <div id="uploaded-file" class="flex items-center">
                                        <span class="text-sm text-gray-600 me-2"><a href="{{ asset('storage/'.$beranda->file) }}" target="_blank">{{ $beranda->file }}</a></span>
                                        <button type="button" class="text-red-500 hover:text-red-700" onclick="removeFile()">Delete</button>
                                    </div>
                                @endif

                                <input type="file" name="file" id="file" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-2 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400" style="display: {{ $beranda->file ? 'none' : 'block' }};">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label for="status" class="block text-sm font-medium mb-2 dark:text-white">Status</label>
                                <select id="status" name="status" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <option>Select status...</option>
                                    <option value="active" @if ( $beranda->status === 'active') selected @endif >Active</option>
                                    <option value="non-active" @if ( $beranda->status === 'non-active') selected @endif >Non Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
                        <button type="button" onclick="window.location.href = '/admin/beranda'"
                            class="py-2 px-10 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gray-500 text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 disabled:opacity-50 disabled:pointer-events-none">
                            Back
                        </button>
                        <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Save changes
                        </button>
                    </div>
                    <input type="hidden" id="id" name="id" class="py-3 px-4 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter..." value="{{ $beranda->id }}">
                </form>
            </div>
        </div>
    </div>

    <!-- Script untuk menghapus file dan menampilkan input file -->
    <script>
        function removeFile() {
            document.getElementById('uploaded-file').style.display = 'none';
            document.getElementById('file').style.display = 'block';
        }
    </script>

</x-app-layout>
