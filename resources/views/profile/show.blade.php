<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex flex-col md:flex-row">
                    <!-- Profile Sidebar -->
                    <div class="md:w-1/3 mb-8 md:mb-0 md:pr-8">
                        <x-follow-ctr :user="$user" class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                            <div class="flex flex-col items-center text-center">
                                <x-user-avatar :user="$user" size="w-24 h-24" class="mb-4" />
                                
                                <h2 class="text-xl font-bold mb-1">{{ $user->name }}</h2>
                                <p class="text-gray-500 mb-3">
                                    <span x-text="followersCount"></span> 
                                    <span class="text-sm">followers</span>
                                </p>
                                
                                @if ($user->bio)
                                    <div class="border-t border-gray-100 w-full pt-4 mt-2 mb-4">
                                        <p class="text-gray-700">{{ $user->bio }}</p>
                                    </div>
                                @endif
                                
                                @if (auth()->user() && auth()->user()->id !== $user->id)
                                    <div class="mt-4 w-full">
                                        <button @click="follow()" 
                                            class="w-full rounded-lg px-4 py-2 text-white font-medium transition-colors duration-200"
                                            x-text="following ? 'Unfollow' : 'Follow'"
                                            :class="following ? 'bg-gray-600 hover:bg-gray-700' : 'bg-blue-600 hover:bg-blue-700'">
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </x-follow-ctr>
                    </div>

                    <!-- Posts Section -->
                    <div class="md:w-2/3">
                        <div class="mb-6 pb-4 border-b border-gray-200">
                            <h1 class="text-2xl md:text-3xl font-bold">Post dari {{ $user->name }}</h1>
                        </div>

                        <div class="space-y-6">
                            @forelse ($posts as $p)
                                <x-post-item :post="$p"></x-post-item>
                            @empty
                                <div class="bg-gray-50 rounded-lg text-center p-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">Belum ada post yang dibuat</p>
                                </div>
                            @endforelse
                        </div>
                        
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>