<div class="max-w-6xl mx-auto py-4 sm:px-6 lg:px-8">
    <!-- Desktop Layout -->
    <div class="hidden lg:flex lg:justify-center lg:gap-6">
        <div class="w-full max-w-3xl">
            {{ $main }}
        </div>
        <div class="w-64 flex-shrink-0">
            <div class="sticky top-20">
                {{ $sidebar }}
            </div>
        </div>
    </div>
    
    <!-- Mobile Layout -->
    <div class="lg:hidden">
        <div>
            {{ $main }}
        </div>
        
        <div x-data="{ showRules: false }" class="mt-6">
            <button 
                @click="showRules = !showRules" 
                class="w-full py-2 px-4 bg-blue-50 text-blue-700 rounded-md flex items-center justify-between"
            >
                <span class="font-medium">Lihat Peraturan RuangKata</span>
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5 transition-transform" 
                    :class="{ 'rotate-180': showRules }"
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="showRules" x-collapse class="mt-2">
                {{ $sidebar }}
            </div>
        </div>
    </div>
</div>