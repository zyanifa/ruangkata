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
        </x-slot>
    </x-two-column-layout>
</x-app-layout>