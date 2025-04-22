<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl mb-4">Create new post</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{  route('post.store') }}" 
                enctype="multipart/form-data" method="post">

                    @csrf

                    <!-- Image -->
                    <div>
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                            :value="old('image')" autofocus />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Title -->
                    <div class="mt-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title')" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select id="category_id" name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                        @selected(old('category_id') == $category->id)>
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
                            {!! old('content') !!}
                        </div>
                        <!-- Hidden Textarea to Store Quill Content -->
                        <textarea id="content" name="content" style="display:none;">{{ old('content') }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <!-- Published At -->
                    <div class="mt-4">
                        <x-input-label for="published_at" :value="__('Published At')" />
                        <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local" name="published_at"
                            :value="old('published_at')" autofocus />
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
</script>