<x-app-layout>
    <x-two-column-layout>
        <x-slot name="main">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <x-category-tabs>
                        No Categories
                    </x-category-tabs>
                </div>
                
                @auth
                <div class="px-4 pb-3 border-t">
                    <label for="followed-toggle" class="inline-flex items-center cursor-pointer mt-3">
                        <input type="checkbox" id="followed-toggle" class="sr-only peer" {{ session('show_followed_only', false) ? 'checked' : '' }}>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900">Hanya dari yang difollow</span>
                    </label>
                </div>
                @endauth
            </div>
            
            <div id="posts-container" class="mt-8 text-gray-900">
                @include('post.partials.post-list', ['posts' => $posts])
            </div>
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