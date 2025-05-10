<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-3xl mb-4 text-center">
                    Ubah Post: <strong class="font-bold">{{ $post->title }}</strong>
                </h1>
                <form action="{{  route('post.update', $post->id) }}" 
                enctype="multipart/form-data" method="post">

                    @csrf
                    @method('put')
                    
                    <!-- Image Preview -->
                    <div id="image-preview-container" class="flex justify-center flex-col items-center mb-4"></div>

                    <!-- Current Image -->
                    @if ($post->imageUrl())
                    <div class="mb-8 flex justify-center flex-col items-center" id="current-image-container">
                        <img src="{{ $post->imageUrl('preview') }}" alt="{{ $post->title }}" class="rounded-md max-h-64">
                        <p class="text-sm text-gray-500 mt-1">Foto thumbnail saat ini</p>
                    </div>
                    @endif
                
                    <!-- Image -->
                    <div>
                        <x-input-label for="image" :value="__('Foto Thumbnail')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                            :value="old('image')" autofocus />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Title -->
                    <div class="mt-4">
                        <x-input-label for="title" :value="__('Judul')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title', $post->title)" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Short Description -->
                    <div class="mt-4">
                        <x-input-label for="short_description" :value="__('Deskripsi Singkat')" />
                        <x-text-input id="short_description" class="block mt-1 w-full" type="text" name="short_description"
                            :value="old('short_description', $post->short_description)" autofocus />
                        <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                    </div>
                    
                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Kategori')" />
                        <select id="category_id" name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                        @selected(old('category_id', $post->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Content -->
                    <div class="mt-4">
                        <x-input-label for="content" :value="__('Konten')" />
                        <div class="main-container">
                            <div class="editor-container editor-container_classic-editor" id="editor-container">
                                <div class="editor-container__editor">
                                    <textarea id="editor" name="content">{{ old('content', $post->content) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>
                    
                    <!-- Published At -->
                    <div class="mt-4">
                        <x-input-label for="published_at" :value="__('Waktu Publikasi')" />
                        <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local" name="published_at"
                            :value="old('published_at', $post->published_at)" autofocus />
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>

                    <div class="flex items-center mt-4">
                        <x-primary-button>
                            Ubah
                        </x-primary-button>
                        <a href="{{ route('post.show', ['username' => $post->user->username, 'post' => $post->slug]) }}" class="text-sm text-gray-600 hover:text-gray-900 ml-4">
                            {{ __('Batal') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>