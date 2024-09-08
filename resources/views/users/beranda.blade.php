<x-user-layout>
    <x-slot name="header">
        {{ __('Pengumuman') }}
    </x-slot>

    <!-- Background -->
    <style>
        body {
            background-color: #F9FAFB;
        }
    </style>

    <!-- Container utama yang memiliki tinggi layar penuh -->
    <div class="w-full pt-4 px-2 sm:px-4 md:px-10 lg:ps-80 mx-auto flex flex-col">
        <div class="p-4 bg-white rounded-lg shadow-md flex-grow flex flex-col justify-between">
            <!-- Menampilkan daftar posts -->
            <!-- Slider -->
            <div data-hs-carousel='{
                "loadingClasses": "opacity-0"
            }' class="relative mt-6 h-full flex-grow">
                <div class="hs-carousel relative overflow-hidden w-full h-full min-h-96 bg-white rounded-lg">
                    <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0 h-full">
                        @if($posts->count())
                        @foreach($posts as $post)
                        <div class="hs-carousel-slide p-4 flex flex-col justify-between h-full">
                            <!-- Judul Post -->
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                                {{ $post->title }}
                            </h2>

                            <!-- Deskripsi Post -->
                            <p class="text-gray-600 mb-4">
                                {{ $post->body }}
                            </p>

                            <!-- Preview dan Download File -->
                            @if($post->file)
                            <div class="mb-4">
                                @if(Str::endsWith($post->file, ['.jpg', '.jpeg', '.png', '.gif']))
                                    <!-- Preview Image -->
                                    <img src="{{ asset('storage/'.$post->file) }}" alt="Preview Image" class="w-full h-48 object-cover rounded-lg">
                                @elseif(Str::endsWith($post->file, ['.pdf']))
                                    <!-- Preview PDF -->
                                    <div class="relative h-64 overflow-hidden">
                                        <embed src="{{ asset('storage/'.$post->file) }}" type="application/pdf" width="100%" height="100%" class="rounded-lg absolute top-0 left-0 w-full h-full border-none" />
                                    </div>
                                @endif
                                <!-- Link Download -->
                                <a href="{{ asset('storage/'.$post->file) }}" download class="text-blue-500 hover:underline">
                                    Download File
                                </a>
                            </div>
                            @endif

                            <!-- Tanggal Dibuat dan Diperbarui -->
                            <div class="text-right text-sm text-gray-500 mt-auto">
                                <span>Created at: {{ $post->created_at->format('d M Y, H:i') }}</span><br>
                                <span>Updated at: {{ $post->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="hs-carousel-slide p-4 flex flex-col justify-between h-full">
                            <div class="flex justify-center h-full bg-gray-300 p-6 dark:bg-neutral-700">
                                <span class="self-center text-4xl text-gray-800 transition duration-700 dark:text-white">Tidak ada Pengumuman</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tombol Navigasi Carousel -->
                <button type="button" class="hs-carousel-prev hs-carousel:disabled:opacity-50 disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-s-lg">
                    <span class="text-2xl" aria-hidden="true">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                    </span>
                    <span class="sr-only">Previous</span>
                </button>
                <button type="button" class="hs-carousel-next hs-carousel:disabled:opacity-50 disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-e-lg">
                    <span class="sr-only">Next</span>
                    <span class="text-2xl" aria-hidden="true">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </span>
                </button>

                <!-- Pagination Carousel -->
                <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 space-x-2">
                    @if($posts->count())
                    @foreach($posts as $post)
                        <span class="hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer"></span>
                    @endforeach
                    @endif
                </div>
            </div>
            <!-- End Slider -->
        </div>
    </div>
</x-user-layout>
