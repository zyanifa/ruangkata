@props(['showCancel' => false])

<form action="{{ route('comments.store', $post) }}#comments-section" method="POST" class="mt-4">
    @csrf
    <textarea 
        name="content" 
        rows="3"
        class="w-full px-4 py-2 text-gray-700 border rounded-lg focus:outline-none focus:border-indigo-500"
        placeholder="Write a comment..."
    ></textarea>
    
    @if($parentComment)
        <input type="hidden" name="parent_id" value="{{ $parentComment->id }}">
    @endif
    
    <div class="flex justify-end mt-2">
        @if($showCancel)
        <button 
            type="button" 
            class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none"
            onclick="this.closest('.reply-form').classList.add('hidden')">
            Cancel
        </button>
        @endif
        <button 
            type="submit" 
            class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 rounded-lg hover:bg-indigo-600 focus:outline-none">
            Post Comment
        </button>
    </div>
</form>