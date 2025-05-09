<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">
                    Laporkan 
                    @if ($type === 'post')
                        Post
                    @elseif ($type === 'comment')
                        Komentar
                    @endif
                </h2>
                
                <div class="mb-4 p-4 bg-gray-50 rounded">
                    @if ($type === 'post')
                        <div class="font-semibold">{{ $model->title }}</div>
                        <div class="text-sm text-gray-600">
                            {{ Str::limit($model->short_description, 100) }}
                        </div>
                    @elseif ($type === 'comment')
                        <div class="text-sm text-gray-600">
                            {{ Str::limit($model->content, 100) }}
                        </div>
                    @endif
                </div>
                
                <form method="POST" action="{{ route('report.store', ['type' => $type, 'id' => $model->id]) }}">
                    @csrf
                    
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <!-- Reason Selection -->
                    <div class="mb-4">
                        <x-input-label for="reason" :value="__('Alasan Laporan')" />
                        
                        <select id="reason" name="reason" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Pilih alasan laporan</option>
                            @foreach ($reasons as $value => $label)
                                <option value="{{ $value }}" {{ old('reason') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        
                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                    </div>
                    
                    <!-- Additional Details -->
                    <div class="mb-4">
                        <x-input-label for="details" :value="__('Detail Tambahan (Opsional)')" />
                        
                        <textarea
                            id="details"
                            name="details"
                            rows="3"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                            placeholder="Berikan keterangan tambahan untuk membantu kami memahami masalah..."
                        >{{ old('details') }}</textarea>
                        
                        <x-input-error :messages="$errors->get('details')" class="mt-2" />
                    </div>
                    
                    <div class="flex items-center justify-end mt-6">
                        @if ($type === 'post')
                            <a href="{{ route('post.show', ['username' => $model->user->username, 'post' => $model->slug]) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                        @elseif ($type === 'comment')
                            <a href="{{ route('post.show', ['username' => $model->post->user->username, 'post' => $model->post->slug]) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                        @endif
                        
                        <x-primary-button>
                            {{ __('Kirim Laporan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>