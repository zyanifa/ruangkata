<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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
                            {{ $post->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('d M Y') }}
                        </div>
                    </div>

                </div>
                <!-- User Avatar -->

                <div class="flex justify-between items-center mt-4">
                    @if ($post->user_id === Auth::id())
                        <div class="w-full py-4 mt-4 border-t border-b border-gray-200">
                            <x-primary-button href="{{ route('post.edit', $post->slug) }}">
                                Edit Post
                            </x-primary-button>
                            <form class="inline-block" action="{{ route('post.destroy', $post) }}" method="post">
                                @csrf
                                @method('delete')
                                <x-danger-button>
                                    Delete Post
                                </x-danger-button>
                            </form>
                        </div>
                    @endif

                    @auth
                        @if ($post->user_id !== Auth::id())
                            <div class="mt-2 ml-auto">
                                <button
                                    onclick="window.location.href='{{ route('report.form', ['type' => 'post', 'id' => $post->id]) }}'"
                                    class="text-sm text-red-600 hover:text-red-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                    </svg>
                                    Laporkan Postingan
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

                <div class="mt-8">
                    <span class="px-4 py-2 bg-gray-200 rounded-2xl">
                        {{ $post->category->name }}
                    </span>
                </div>
                
                <!-- Comments Section -->
                <div id="comments-section" class="mt-12 border-t pt-8">
                    <h3 class="text-xl font-bold mb-6">Comments ({{ $post->allComments->count() }})</h3>
                    
                    @auth
                        <x-comment-form :post="$post" />
                    @else
                        <div class="bg-gray-100 p-4 rounded-lg text-center">
                            <p><a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a> or <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Register</a> to leave a comment</p>
                        </div>
                    @endauth
                    
                    <div class="mt-8 space-y-6">
                        @forelse($comments as $comment)
                            <div id="comment-{{ $comment->id }}">
                                <x-comment-item :comment="$comment" :post="$post" />
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $comments->fragment('comments-section')->links() }}
                    </div>
                </div>
                <!-- End Comments Section -->

            </div>
        </div>
    </div>
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
                // Store the current scroll position in localStorage
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
        if (confirm('Are you sure you want to delete this comment?')) {
            document.getElementById(`delete-form-${commentId}`).submit();
        }
    }
</script>