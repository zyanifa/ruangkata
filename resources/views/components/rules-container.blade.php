<div {{ $attributes->merge(['class' => 'bg-white p-4 rounded-lg shadow-md']) }} x-data="{ expandedRule: null }">
    <h4 class="font-bold text-lg mb-3 text-gray-700 flex items-center justify-between">
        <span>Peraturan RuangKata</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </h4>
    
    <ul class="space-y-3 text-sm">
        <li x-data="{ id: 1 }" class="rounded-lg overflow-hidden">
            <button 
                @click="expandedRule = expandedRule === 1 ? null : 1" 
                class="flex items-start w-full text-left p-2 hover:bg-gray-50 rounded-lg"
                :class="{ 'bg-blue-50': expandedRule === 1 }"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-600 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Gunakan kata yang sopan dalam berinteraksi</span>
            </button>
            <div x-show="expandedRule === 1" x-collapse class="pl-8 pr-2 pb-2 text-gray-600 text-xs">
                Gunakan bahasa yang sopan dan menghargai. Hindari kata-kata kasar, vulgar, atau menyinggung SARA.
            </div>
        </li>
        
        <li x-data="{ id: 2 }" class="rounded-lg overflow-hidden">
            <button 
                @click="expandedRule = expandedRule === 2 ? null : 2" 
                class="flex items-start w-full text-left p-2 hover:bg-gray-50 rounded-lg"
                :class="{ 'bg-blue-50': expandedRule === 2 }"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-600 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Laporkan post atau komentar yang melanggar aturan</span>
            </button>
            <div x-show="expandedRule === 2" x-collapse class="pl-8 pr-2 pb-2 text-gray-600 text-xs">
                Jika Anda menemukan konten yang melanggar aturan komunitas, segera laporkan agar moderator dapat meninjau.
            </div>
        </li>
        
        <li x-data="{ id: 3 }" class="rounded-lg overflow-hidden">
            <button 
                @click="expandedRule = expandedRule === 3 ? null : 3" 
                class="flex items-start w-full text-left p-2 hover:bg-gray-50 rounded-lg"
                :class="{ 'bg-blue-50': expandedRule === 3 }"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-600 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Hormati hak cipta dan kekayaan intelektual</span>
            </button>
            <div x-show="expandedRule === 3" x-collapse class="pl-8 pr-2 pb-2 text-gray-600 text-xs">
                Selalu berikan kredit/sumber saat mengutip atau menggunakan karya orang lain. Jangan melakukan plagiarisme.
            </div>
        </li>
        
        <li x-data="{ id: 4 }" class="rounded-lg overflow-hidden">
            <button 
                @click="expandedRule = expandedRule === 4 ? null : 4" 
                class="flex items-start w-full text-left p-2 hover:bg-gray-50 rounded-lg"
                :class="{ 'bg-blue-50': expandedRule === 4 }"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-600 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Berikan kritik yang konstruktif</span>
            </button>
            <div x-show="expandedRule === 4" x-collapse class="pl-8 pr-2 pb-2 text-gray-600 text-xs">
                Kritik adalah tentang ide, bukan orangnya. Sampaikan pendapat dengan cara yang membangun, bukan menjatuhkan.
            </div>
        </li>
        
        <li x-data="{ id: 5 }" class="rounded-lg overflow-hidden">
            <button 
                @click="expandedRule = expandedRule === 5 ? null : 5" 
                class="flex items-start w-full text-left p-2 hover:bg-gray-50 rounded-lg"
                :class="{ 'bg-blue-50': expandedRule === 5 }"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-600 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Jangan menyebarkan informasi menyesatkan</span>
            </button>
            <div x-show="expandedRule === 5" x-collapse class="pl-8 pr-2 pb-2 text-gray-600 text-xs">
                Pastikan informasi yang dibagikan akurat dan dapat diverifikasi. Jangan menyebarkan berita palsu atau hoax.
            </div>
        </li>
    </ul>
</div>