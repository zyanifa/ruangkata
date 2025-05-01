<x-app-layout>
    <x-two-column-layout>
        <x-slot name="main">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-2xl mb-4">{{ $post->title }}</h1>

                <!-- User Avatar -->
                <div class="flex gap-4">
                    <x-user-avatar :user="$post->user" />

                    <div>
                        <x-follow-ctr :user="$post->user" class="flex gap-2">
                            <a href="{{ route('profile.show', $post->user) }}" class="hover:underline">
                                {{ $post->user->name }}
                            </a>
                            
                            @auth
                                &middot;
                                <button 
                                    x-text="following ? 'Unfollow' : 'Follow'" 
                                    :class="following ? 'text-red-600' : 'text-emerald-600'"
                                    @click="follow()"
                                    x-show="!isSelf">
                                </button>
                            @endauth
                        </x-follow-ctr>

                        <div class="flex gap-2 text-sm text-gray-500">
                            {{ $post->readTime() }} menit baca
                            &middot;
                            {{ $post->created_at->format('d M Y') }}
                        </div>
                        
                        <!-- Post Action Buttons -->
                        @if ($post->user_id === Auth::id())
                            <div class="mt-2 flex gap-2">
                                <button onclick="window.location.href='{{ route('post.edit', $post->slug) }}'" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-3 mr-1">
                                        <path d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                        <path d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                                    </svg>
                                    Ubah
                                </button>
                                <button onclick="if(confirm('Apakah Anda yakin ingin menghapus postingan ini?')){document.getElementById('delete-post-form').submit();}" class="text-sm text-red-600 hover:text-red-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-3 mr-1">
                                        <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" />
                                    </svg>
                                    Hapus
                                </button>
                                <form id="delete-post-form" class="hidden" action="{{ route('post.destroy', $post) }}" method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- User Avatar -->

                <div class="flex justify-between items-center mt-4">
                    @auth
                        @if ($post->user_id !== Auth::id())
                            <div class="mt-2 ml-auto">
                                <button
                                    onclick="if(confirm('Apakah Anda yakin ingin melaporkan postingan ini?')) { window.location.href='{{ route('report.form', ['type' => 'post', 'id' => $post->id]) }}'; }"
                                    class="text-sm text-red-600 hover:text-red-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                    </svg>
                                    Laporkan Post
                                </button>
                            </div>
                        @endif
                    @endauth
                </div>

                <!-- Clap Section -->
                <x-clap-button :post="$post" />
                <!-- Clap Section -->

                <!-- Content Section -->
                <div class="mt-8">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full">
                
                    <div class="mt-4">
                        <div class="prose prose-base max-w-none ck-content [&>*]:my-2 prose-headings:font-bold prose-headings:my-3 prose-h1:text-2xl prose-h2:text-xl prose-h3:text-lg prose-ul:list-disc prose-ol:list-decimal prose-blockquote:before:content-none prose-blockquote:after:content-none prose-code:before:content-[''] prose-code:after:content-['']">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>

                @if($post->updated_at->gt($post->created_at))
                <div class="mt-6 text-sm text-gray-500 italic">
                    Terakhir diubah pada {{ $post->updated_at->format('d M Y, H:i') }}
                </div>
                @endif

                <div class="mt-8">
                    <span class="px-4 py-2 bg-gray-200 rounded-2xl">
                        {{ $post->category->name }}
                    </span>
                </div>
                
                <!-- Comments Section -->
                <div id="comments-section" class="mt-12 border-t pt-8">
                    <h3 class="text-xl font-bold mb-6">Komentar ({{ $post->allComments->count() }})</h3>
                    
                    @auth
                        <x-comment-form :post="$post" />
                    @else
                        <div class="bg-gray-100 p-4 rounded-lg text-center">
                            <p><a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Masuk</a> atau <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">daftar</a> untuk menulis komentar</p>
                        </div>
                    @endauth
                    
                    <div class="mt-8 space-y-6">
                        @forelse($comments as $comment)
                            <div id="comment-{{ $comment->id }}">
                                <x-comment-item :comment="$comment" :post="$post" />
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Belum ada komentar.</p>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $comments->fragment('comments-section')->links() }}
                    </div>
                </div>
                <!-- End Comments Section -->
            </div>
        </x-slot>
        
        <x-slot name="sidebar">
            <x-rules-container />
        </x-slot>
    </x-two-column-layout>
</x-app-layout>

<script>
    let currentlyOpenForm = null; // Track the currently open form
    
    function toggleEditForm(commentId, show) {
        const contentElement = document.getElementById(`comment-content-${commentId}`);
        const formElement = document.getElementById(`edit-form-${commentId}`);
        
        // If we're trying to open a form and another form is already open, close it first
        if (show && currentlyOpenForm && currentlyOpenForm !== formElement) {
            // If the current form is an edit form, restore the comment content
            if (currentlyOpenForm.id.startsWith('edit-form-')) {
                const currentCommentId = currentlyOpenForm.id.replace('edit-form-', '');
                document.getElementById(`comment-content-${currentCommentId}`).classList.remove('hidden');
            }
            
            // Hide the currently open form
            currentlyOpenForm.classList.add('hidden');
            currentlyOpenForm = null;
        }
        
        if (show) {
            contentElement.classList.add('hidden');
            formElement.classList.remove('hidden');
            currentlyOpenForm = formElement;
        } else {
            contentElement.classList.remove('hidden');
            formElement.classList.add('hidden');
            if (currentlyOpenForm === formElement) {
                currentlyOpenForm = null;
            }
        }
    }
    
    function toggleReplyForm(commentId) {
        const replyForm = document.getElementById(`reply-form-${commentId}`);
        
        // If we're trying to open a form and another form is already open, close it first
        if (!replyForm.classList.contains('hidden') && currentlyOpenForm === replyForm) {
            // We're closing the current form
            replyForm.classList.add('hidden');
            currentlyOpenForm = null;
            return;
        }
        
        if (currentlyOpenForm && currentlyOpenForm !== replyForm) {
            // If the current form is an edit form, restore the comment content
            if (currentlyOpenForm.id.startsWith('edit-form-')) {
                const currentCommentId = currentlyOpenForm.id.replace('edit-form-', '');
                document.getElementById(`comment-content-${currentCommentId}`).classList.remove('hidden');
            }
            
            // Hide the currently open form
            currentlyOpenForm.classList.add('hidden');
        }
        
        // Toggle the reply form visibility
        replyForm.classList.toggle('hidden');
        
        // Update the currently open form reference
        currentlyOpenForm = replyForm.classList.contains('hidden') ? null : replyForm;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Check if URL has a hash fragment
        if (window.location.hash) {
            // Scroll to the element after a short delay to ensure DOM is fully loaded
            setTimeout(function() {
                const element = document.querySelector(window.location.hash);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth' });
                }
            }, 300);
        }
        
        // Handle pagination links
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                localStorage.setItem('commentScrollPosition', window.scrollY);
            });
        });
        
        // Check if we have a stored position
        const savedPosition = localStorage.getItem('commentScrollPosition');
        if (savedPosition !== null && !window.location.hash) {
            setTimeout(() => {
                window.scrollTo(0, parseInt(savedPosition));
                // Clear the stored position
                localStorage.removeItem('commentScrollPosition');
            }, 300);
        }
        
        // Apply syntax highlighting to all code blocks
        document.querySelectorAll('pre code, .ck-code-block pre, .ck-code-block-content pre').forEach((block) => {
            hljs.highlightElement(block);
        });
        
        // For inline code
        document.querySelectorAll('.ck-content code:not(pre code)').forEach((element) => {
            hljs.highlightElement(element);
        });
    });

    function deleteComment(commentId) {
        if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
            document.getElementById(`delete-form-${commentId}`).submit();
        }
    }
</script>