<!-- filepath: d:\ruangkata\resources\views\components\category-tabs.blade.php -->
<div class="relative">
    <div class="flex overflow-x-auto pb-2 hide-scrollbar" style="scroll-behavior: smooth;">
        <ul class="flex text-sm font-medium text-center text-gray-500">
            <li class="mx-1 whitespace-nowrap">
                <a href="/" class="{{
                request('category') 
                ? 'inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100' 
                : 'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' }}">
                    Semua
                </a>
            </li>
            @forelse ($categories as $category)
                <li class="mx-1 whitespace-nowrap">
                    <a href="{{ route('post.byCategory', $category) }}"
                        class="{{ 
                            Route::currentRouteNamed('post.byCategory') && request('category')->id == $category->id 
                            ? 'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' 
                            : 'inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100' 
                        }}">
                        {{ $category->name }}
                    </a>
                </li>
            @empty
                {{ $slot }}
            @endforelse
        </ul>
    </div>
    
    <div class="absolute right-0 top-0 bg-gradient-to-l from-white to-transparent w-12 h-full flex items-center justify-center">
        <button class="scroll-right text-gray-500 hover:text-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
    <div class="absolute left-0 top-0 bg-gradient-to-r from-white to-transparent w-12 h-full flex items-center justify-center">
        <button class="scroll-left text-gray-500 hover:text-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    document.querySelector('.scroll-right').addEventListener('click', function() {
        document.querySelector('.overflow-x-auto').scrollBy({ left: 200, behavior: 'smooth' });
    });
    
    document.querySelector('.scroll-left').addEventListener('click', function() {
        document.querySelector('.overflow-x-auto').scrollBy({ left: -200, behavior: 'smooth' });
    });
</script>