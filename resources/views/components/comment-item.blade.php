<div class="comment-item p-4 mb-4 bg-white rounded-lg shadow">
    <div class="flex items-start">
        <x-user-avatar :user="$comment->user" size="w-10 h-10" />
        
        <div class="ml-4 flex-1">
            <div class="flex justify-between">
                <h4 class="font-medium text-gray-800">
                    <a href="{{ route('profile.show', $comment->user->username) }}" class="hover:underline">
                        {{ $comment->user->name }}
                    </a>
                </h4>
                <span class="text-sm text-gray-500">
                    {{ $comment->created_at->locale('id')->diffForHumans() }}
                    @if($comment->updated_at->gt($comment->created_at))
                        <span class="text-xs text-gray-400 ml-1">(diubah)</span>
                    @endif
                </span>
            </div>
            
            <!-- Comment Content -->
            <div id="comment-content-{{ $comment->id }}">
                <p class="mt-1 text-gray-700">{{ $comment->content }}</p>
            </div>
            
            <!-- Edit Form (Hidden by default) -->
            <div id="edit-form-{{ $comment->id }}" class="mt-2 hidden">
                <form action="{{ route('comments.update', $comment) }}#comment-{{ $comment->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea 
                        name="content" 
                        rows="3"
                        class="w-full px-4 py-2 text-gray-700 border rounded-lg focus:outline-none focus:border-indigo-500"
                    >{{ $comment->content }}</textarea>
                    
                    <div class="flex justify-end mt-2">
                        <button 
                            type="button" 
                            class="px-3 py-1 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none"
                            onclick="toggleEditForm('{{ $comment->id }}', false)">
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="px-3 py-1 text-sm font-medium text-white bg-indigo-500 rounded-lg hover:bg-indigo-600 focus:outline-none">
                            Ubah
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-2 flex items-center justify-between">
                <div class="flex items-center">
                    @auth
                    <button 
                        onclick="toggleReplyForm('{{ $comment->id }}')"
                        class="flex items-center text-sm text-gray-500 hover:text-gray-700 mr-4">
                        <!-- Reply Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                        Balas
                    </button>
                        
                        @if($comment->user_id === auth()->id())
                            <button 
                                onclick="toggleEditForm('{{ $comment->id }}', true)"
                                class="flex items-center text-sm text-gray-500 hover:text-gray-700 mr-4">
                                <!-- Edit Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Ubah
                            </button>
                            
                            <!-- Change from form to button with onclick handler -->
                            <button 
                                onclick="deleteComment({{ $comment->id }})"
                                class="flex items-center text-sm text-gray-500 hover:text-gray-700">
                                <!-- Delete Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus
                            </button>
                            
                            <!-- Hidden form for delete action -->
                            <form id="delete-form-{{ $comment->id }}" action="{{ route('comments.destroy', $comment) }}#comments-section" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    @endauth
                </div>

                @auth
                @if($comment->user_id !== auth()->id())
                    <div class="group relative">
                        <button 
                            onclick="window.location.href='{{ route('report.form', ['type' => 'comment', 'id' => $comment->id]) }}'"
                            class="flex items-center text-sm text-gray-500 hover:text-red-600"
                            title="Laporkan">
                            <!-- Report Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                            </svg>
                        </button>
                    </div>
                @endif
                @endauth
            </div>
            
            <!-- Reply Form (Hidden by default) -->
            <div id="reply-form-{{ $comment->id }}" class="mt-4 hidden reply-form">
                <x-comment-form :post="$post" :parent-comment="$comment" :show-cancel="true" />
            </div>
            
            <!-- Replies -->
            @if($comment->replies->count() > 0)
                <!-- Grey line break between main comment and replies -->
                <hr class="my-4 border-gray-200">
                
                <div class="ml-0 mt-4 pl-4">
                    @foreach($comment->replies as $reply)
                        <div id="comment-{{ $reply->id }}" class="reply-item mb-3">
                            <div class="flex items-start">
                                <x-user-avatar :user="$reply->user" size="w-10 h-10" />
                                
                                <div class="ml-3 flex-1">
                                    <div class="flex justify-between">
                                        <h4 class="font-medium text-gray-800">
                                            <a href="{{ route('profile.show', $reply->user->username) }}" class="hover:underline">
                                                {{ $reply->user->name }}
                                            </a>
                                        </h4>
                                        <span class="text-sm text-gray-500">
                                            {{ $reply->created_at->locale('id')->diffForHumans() }}
                                            @if($reply->updated_at->gt($reply->created_at))
                                                <span class="text-xs text-gray-400 ml-1">(diubah)</span>
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <!-- Reply Content -->
                                    <div id="comment-content-{{ $reply->id }}">
                                        <p class="mt-1 text-gray-700">{{ $reply->content }}</p>
                                    </div>
                                    
                                    <!-- Edit Reply Form (Hidden by default) -->
                                    <div id="edit-form-{{ $reply->id }}" class="mt-2 hidden">
                                        <form action="{{ route('comments.update', $reply) }}#comment-{{ $reply->id }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <textarea 
                                                name="content" 
                                                rows="2"
                                                class="w-full px-3 py-1 text-gray-700 border rounded-lg focus:outline-none focus:border-indigo-500"
                                            >{{ $reply->content }}</textarea>
                                            
                                            <div class="flex justify-end mt-2">
                                                <button 
                                                    type="button" 
                                                    class="px-2 py-1 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none"
                                                    onclick="toggleEditForm('{{ $reply->id }}', false)">
                                                    Batal
                                                </button>
                                                <button 
                                                    type="submit" 
                                                    class="px-2 py-1 text-sm font-medium text-white bg-indigo-500 rounded-lg hover:bg-indigo-600 focus:outline-none">
                                                    Ubah
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <div class="mt-1 flex items-center justify-between">
                                        @if($reply->user_id === auth()->id())
                                        <div class="flex items-center">
                                            <button 
                                                onclick="toggleEditForm('{{ $reply->id }}', true)"
                                                class="flex items-center text-sm text-gray-500 hover:text-gray-700 mr-4">
                                                <!-- Edit Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Ubah
                                            </button>
                                            
                                            <!-- Change from form to button with onclick handler -->
                                            <button 
                                                onclick="deleteComment({{ $reply->id }})"
                                                class="flex items-center text-sm text-gray-500 hover:text-gray-700">
                                                <!-- Delete Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                            
                                            <!-- Hidden form for delete action -->
                                            <form id="delete-form-{{ $reply->id }}" action="{{ route('comments.destroy', $reply) }}#comments-section" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                        @endif

                                        @auth
                                        @if($reply->user_id !== auth()->id())
                                        <div class="ml-auto group relative">
                                            <button
                                                onclick="window.location.href='{{ route('report.form', ['type' => 'comment', 'id' => $reply->id]) }}'"
                                                class="flex items-center text-sm text-gray-500 hover:text-red-600"
                                                title="Laporkan">
                                                <!-- Report Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                                </svg>
                                            </button>
                                        </div>
                                        @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Grey line break between replies (except after the last reply) -->
                        @if(!$loop->last)
                            <hr class="my-3 border-gray-200">
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>