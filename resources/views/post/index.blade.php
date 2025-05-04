<x-app-layout>
    <x-two-column-layout>
        <x-slot name="main">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <x-category-tabs>
                        No Categories
                    </x-category-tabs>
                </div>
            </div>
            <div class="mt-8 text-gray-900">
                @forelse ($posts as $p)
                    <x-post-item :post="$p"></x-post-item>
                @empty
                    <div class="text-center text-gray-400 py-16">Tidak ada post</div>
                @endforelse
            </div>

            {{ $posts->links() }}
        </x-slot>
        
        <x-slot name="sidebar">
            <x-rules-container />
            <div class="mt-3 text-left">
                <a href="{{ route('about') }}" class="text-blue-600 text-sm hover:underline flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tentang RuangKata
                </a>
            </div>
        </x-slot>
    </x-two-column-layout>
</x-app-layout>