export default function initializeComments() {
    let currentlyOpenForm = null; // Track the currently open form
    
    // Expose these functions to the global scope so they can be called from HTML
    window.toggleEditForm = function(commentId, show) {
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
    };
    
    window.toggleReplyForm = function(commentId) {
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
    };
    
    window.deleteComment = function(commentId) {
        if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
            document.getElementById(`delete-form-${commentId}`).submit();
        }
    };

    // Handle scrolling and pagination logic
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
}