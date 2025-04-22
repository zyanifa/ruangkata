<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl mb-4">
                Update Post: <strong class="font-bold">{{ $post->title }}</strong>
            </h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{  route('post.update', $post->id) }}" 
                enctype="multipart/form-data" method="post">

                    @csrf
                    @method('put')

                    <!-- Image -->
                    @if ($post->imageUrl())
                    <div class="mb-8 flex justify-center flex-col items-center" id="current-image-container">
                        <p class="text-sm text-gray-500 mb-1">Current image:</p>
                        <img src="{{ $post->imageUrl('preview') }}" alt="{{ $post->title }}" class="rounded-md max-h-64">
                    </div>
                    @endif
                
                    <!-- Image -->
                    <div>
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                            :value="old('image')" autofocus />
                        <div id="image-preview-container" class="mt-2"></div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Title -->
                    <div class="mt-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title', $post->title)" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Short Description -->
                    <div class="mt-4">
                        <x-input-label for="short_description" :value="__('Short Description')" />
                        <x-text-input id="short_description" class="block mt-1 w-full" type="text" name="short_description"
                            :value="old('short_description', $post->short_description)" autofocus />
                        <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                    </div>
                    
                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" />
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
                        <x-input-label for="content" :value="__('Content')" />
                        <!-- Quill Editor Container -->
                        <div id="editor-container" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" style="min-height: 400px; resize: vertical; overflow: auto;">
                            {!! old('content', $post->content) !!}
                        </div>
                        <!-- Hidden Textarea to Store Quill Content -->
                        <textarea id="content" name="content" style="display:none;">{{ old('content', $post->content) }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>
                    
                    <!-- Published At -->
                    <div class="mt-4">
                        <x-input-label for="published_at" :value="__('Published At')" />
                        <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local" name="published_at"
                            :value="old('published_at', $post->published_at)" autofocus />
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>

                    <x-primary-button class="mt-4">
                        Submit
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    // Initialize Quill Editor
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['code-block'],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Update hidden textarea whenever content changes
    quill.on('text-change', function() {
    document.querySelector('#content').value = quill.root.innerHTML;
    
    // Re-highlight code blocks after content changes
    document.querySelectorAll('#editor-container pre.ql-syntax').forEach((block) => {
        hljs.highlightElement(block);
        });
    });

    // Optional: Also set initial content if there's old input
    @if(old('content'))
    quill.root.innerHTML = `{!! old('content') !!}`;
    @endif

    // Still keep form submission handler as backup
    var form = document.querySelector('form');
    form.onsubmit = function() {
        document.querySelector('#content').value = quill.root.innerHTML;
    };

    document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('image-preview-container');
    const currentImageContainer = document.getElementById('current-image-container');
    
    // Center the current image if it exists
    if (currentImageContainer) {
        const currentImg = currentImageContainer.querySelector('img');
        if (currentImg) {
            currentImageContainer.classList.add('flex', 'justify-center', 'flex-col', 'items-center');
        }
    }
    
    imageInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        
        if (this.files && this.files[0]) {
            // Hide current image when a new one is selected
            if (currentImageContainer) {
                currentImageContainer.style.display = 'none';
            }
            
            // Add flex container for centering
            previewContainer.className = 'mt-2 flex justify-center flex-col items-center';
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'mt-2 rounded-md max-h-64 max-w-full';
                preview.alt = 'New Image Preview';
                
                const previewText = document.createElement('p');
                previewText.className = 'text-sm text-gray-500 mt-1';
                previewText.textContent = 'Preview of new image';
                
                previewContainer.appendChild(preview);
                previewContainer.appendChild(previewText);
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            // Show current image again if file selection is canceled
            if (currentImageContainer) {
                currentImageContainer.style.display = 'block';
            }
        }
    });
});
</script>