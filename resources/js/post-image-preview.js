/**
 * Handles image preview functionality for post forms
 * Works with both create and edit forms
 */
export default function initializeImagePreview() {
    const imageInput = document.getElementById('image');
    // Early return if we're not on a page with an image upload field
    if (!imageInput) return;
    
    const previewContainer = document.getElementById('image-preview-container');
    const currentImageContainer = document.getElementById('current-image-container');
    
    imageInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        
        if (this.files && this.files[0]) {
            // For create page, add the flex container classes if not already present
            if (!previewContainer.classList.contains('flex')) {
                previewContainer.className = 'mt-2 flex justify-center flex-col items-center';
            }
            
            // Hide current image when a new one is selected (edit page only)
            if (currentImageContainer) {
                currentImageContainer.style.display = 'none';
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = currentImageContainer ? 
                    'rounded-md max-h-64 max-w-full' : 
                    'mt-2 rounded-md max-h-64 max-w-full';
                preview.alt = 'Preview foto thumbnail';
                
                const previewText = document.createElement('p');
                previewText.className = 'text-sm text-gray-500 mt-1';
                previewText.textContent = currentImageContainer ? 
                    'Preview foto thumbnail baru' : 
                    'Preview foto thumbnail';
                
                previewContainer.appendChild(preview);
                previewContainer.appendChild(previewText);
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            // Show current image again if file selection is canceled (edit page only)
            if (currentImageContainer) {
                currentImageContainer.style.display = 'block';
            }
        }
    });
}