<!-- filepath: d:\ruangkata\resources\views\components\category-tabs.blade.php -->
<div class="relative">
    <div id="categoryTabsContainer" class="flex overflow-x-auto pb-2 hide-scrollbar" style="scroll-behavior: smooth;">
        <ul class="flex text-sm font-medium text-center text-gray-500">
            <li class="mx-1 whitespace-nowrap">
                <a href="#" 
                   class="category-link {{!request('category') ? 'active text-white bg-blue-600' : ''}} inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100"
                   data-url="{{ route('dashboard') }}"
                   data-category="all">
                    Semua
                </a>
            </li>
            @forelse ($categories as $category)
                <li class="mx-1 whitespace-nowrap">
                    <a href="#" 
                       class="category-link {{ Route::currentRouteNamed('post.byCategory') && request('category')->id == $category->id ? 'active text-white bg-blue-600' : '' }} inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100"
                       data-url="{{ route('post.byCategory', $category) }}"
                       data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </a>
                </li>
            @empty
                {{ $slot }}
            @endforelse
        </ul>
    </div>
    
    <div class="absolute right-0 top-0 bg-gradient-to-l from-white to-transparent w-12 h-full flex items-center justify-center scroll-gradient-visible">
        <button class="scroll-right text-gray-500 hover:text-gray-700 scroll-button-visible">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
    <div class="absolute left-0 top-0 bg-gradient-to-r from-white to-transparent w-12 h-full flex items-center justify-center scroll-gradient-hidden">
        <button class="scroll-left text-gray-500 hover:text-gray-700 scroll-button-hidden">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
    </div>
</div>