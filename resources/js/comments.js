export default function initializeComments() {
    let currentlyOpenForms = []; // Track the currently open forms (both desktop and mobile)
    
    // Expose these functions to the global scope so they can be called from HTML
    window.toggleEditForm = function(commentId, show) {
        const contentElements = document.querySelectorAll(`[id="comment-content-${commentId}"]`);
        const formElements = document.querySelectorAll(`[id="edit-form-${commentId}"]`);
        
        // If we're trying to open a form and another form is already open, close it first
        if (show && currentlyOpenForms.length > 0) {
            // Close all currently open forms
            currentlyOpenForms.forEach(openForm => {
                if (openForm.id.startsWith('edit-form-')) {
                    const currentCommentId = openForm.id.replace('edit-form-', '');
                    const contentElements = document.querySelectorAll(`[id="comment-content-${currentCommentId}"]`);
                    contentElements.forEach(el => el.classList.remove('hidden'));
                }
                openForm.classList.add('hidden');
            });
            currentlyOpenForms = [];
        }
        
        if (show) {
            contentElements.forEach(el => el.classList.add('hidden'));
            formElements.forEach(el => {
                el.classList.remove('hidden');
                currentlyOpenForms.push(el);
            });
        } else {
            contentElements.forEach(el => el.classList.remove('hidden'));
            formElements.forEach(el => el.classList.add('hidden'));
            currentlyOpenForms = currentlyOpenForms.filter(form => !formElements.includes(form));
        }
    };
    
    window.toggleReplyForm = function(commentId) {
        const replyForms = document.querySelectorAll(`[id="reply-form-${commentId}"]`);
        
        // Check if any form is currently open
        const isAnyFormOpen = Array.from(replyForms).some(form => !form.classList.contains('hidden'));
        
        // If forms are open, close them
        if (isAnyFormOpen) {
            replyForms.forEach(form => {
                form.classList.add('hidden');
            });
            currentlyOpenForms = currentlyOpenForms.filter(form => !Array.from(replyForms).includes(form));
            return;
        }
        
        // Close any other open forms first
        if (currentlyOpenForms.length > 0) {
            currentlyOpenForms.forEach(openForm => {
                if (openForm.id.startsWith('edit-form-')) {
                    const currentCommentId = openForm.id.replace('edit-form-', '');
                    const contentElements = document.querySelectorAll(`[id="comment-content-${currentCommentId}"]`);
                    contentElements.forEach(el => el.classList.remove('hidden'));
                }
                openForm.classList.add('hidden');
            });
            currentlyOpenForms = [];
        }
        
        // Open the reply forms
        replyForms.forEach(form => {
            form.classList.remove('hidden');
            currentlyOpenForms.push(form);
        });
    };
    
    window.deleteComment = function(commentId) {
        if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
            const deleteForm = document.querySelector(`[id="delete-form-${commentId}"]`);
            if (deleteForm) {
                deleteForm.submit();
            }
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