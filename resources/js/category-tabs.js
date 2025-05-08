document.addEventListener('DOMContentLoaded', function() {
    const tabsContainer = document.getElementById('categoryTabsContainer');
    const postsContainer = document.querySelector('#posts-container');
    const categoryLinks = document.querySelectorAll('.category-link');
    
    const scrollRightButton = document.querySelector('.scroll-right');
    const scrollLeftButton = document.querySelector('.scroll-left');
    const rightGradient = scrollRightButton.parentElement;
    const leftGradient = scrollLeftButton.parentElement;
    
    // Function to check scroll position and update button visibility
    function updateScrollButtonsVisibility() {
        // Check if we're at the left edge
        if (tabsContainer.scrollLeft <= 0) {
            scrollLeftButton.classList.add('scroll-button-hidden');
            scrollLeftButton.classList.remove('scroll-button-visible');
            leftGradient.classList.add('scroll-gradient-hidden');
            leftGradient.classList.remove('scroll-gradient-visible');
        } else {
            scrollLeftButton.classList.add('scroll-button-visible');
            scrollLeftButton.classList.remove('scroll-button-hidden');
            leftGradient.classList.add('scroll-gradient-visible');
            leftGradient.classList.remove('scroll-gradient-hidden');
        }
        
        // Check if we're at the right edge
        const scrollRight = tabsContainer.scrollWidth - tabsContainer.clientWidth;
        if (Math.abs(tabsContainer.scrollLeft - scrollRight) < 2) {
            scrollRightButton.classList.add('scroll-button-hidden');
            scrollRightButton.classList.remove('scroll-button-visible');
            rightGradient.classList.add('scroll-gradient-hidden');
            rightGradient.classList.remove('scroll-gradient-visible');
        } else {
            scrollRightButton.classList.add('scroll-button-visible');
            scrollRightButton.classList.remove('scroll-button-hidden');
            rightGradient.classList.add('scroll-gradient-visible');
            rightGradient.classList.remove('scroll-gradient-hidden');
        }
    }
    
    // Initialize button visibility
    updateScrollButtonsVisibility();
    
    // Update visibility when scrolling
    tabsContainer.addEventListener('scroll', updateScrollButtonsVisibility);
    
    // Also update on window resize
    window.addEventListener('resize', updateScrollButtonsVisibility);
    
    // Scroll buttons functionality
    scrollRightButton.addEventListener('click', function() {
        tabsContainer.scrollBy({ left: 200, behavior: 'smooth' });
    });
    
    scrollLeftButton.addEventListener('click', function() {
        tabsContainer.scrollBy({ left: -200, behavior: 'smooth' });
    });
    
    // AJAX category switching
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active state
            document.querySelectorAll('.category-link').forEach(el => {
                el.classList.remove('active', 'text-white', 'bg-blue-600');
                el.classList.add('hover:text-gray-900', 'hover:bg-gray-100');
            });
            
            this.classList.add('active', 'text-white', 'bg-blue-600');
            this.classList.remove('hover:text-gray-900', 'hover:bg-gray-100');
            
            const url = this.getAttribute('data-url');
            const category = this.getAttribute('data-category');
            
            // Show loading state
            if (postsContainer) {
                postsContainer.innerHTML = '<div class="flex justify-center items-center py-16"><svg class="w-6 h-6 custom-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#e5e7eb" stroke-width="4"></circle><path fill="#3b82f6" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';            }
            
            // Update URL without page reload
            window.history.pushState({category: category}, '', url);
            
            // Fetch posts via AJAX
            fetch(url + '?ajax=1')
                .then(response => response.text())
                .then(html => {
                    if (postsContainer) {
                        postsContainer.innerHTML = html;
                        
                        // Setup pagination for AJAX
                        setupPaginationLinks();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (postsContainer) {
                        postsContainer.innerHTML = '<div class="text-center text-red-500 py-16">Error memuat post</div>';
                    }
                });
        });
    });
    
    // Setup pagination links for AJAX
    function setupPaginationLinks() {
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                
                // Show loading state
                if (postsContainer) {
                    postsContainer.innerHTML = '<div class="flex justify-center items-center py-16"><svg class="w-6 h-6 custom-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#e5e7eb" stroke-width="4"></circle><path fill="#3b82f6" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';                }
                
                // Update URL without page reload
                window.history.pushState({}, '', url);
                
                // Fetch posts via AJAX
                fetch(url + '&ajax=1')
                    .then(response => response.text())
                    .then(html => {
                        if (postsContainer) {
                            postsContainer.innerHTML = html;
                            setupPaginationLinks();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (postsContainer) {
                            postsContainer.innerHTML = '<div class="text-center text-red-500 py-16">Error memuat post</div>';
                        }
                    });
            });
        });
    }
    
    // Setup initial pagination links
    setupPaginationLinks();
});