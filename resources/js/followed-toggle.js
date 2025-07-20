document.addEventListener('DOMContentLoaded', function() {
    const followedToggles = document.querySelectorAll('#followed-toggle');
    const postsContainers = document.querySelectorAll('#posts-container');
    
    // Setup functionality for each toggle (desktop and mobile)
    followedToggles.forEach(followedToggle => {
        if (followedToggle) {
            followedToggle.addEventListener('change', function() {
                // Sync all toggles to have the same state
                followedToggles.forEach(toggle => {
                    toggle.checked = this.checked;
                });
                
                // Show loading state in all post containers
                postsContainers.forEach(container => {
                    if (container) {
                        container.innerHTML = '<div class="flex justify-center items-center py-16"><svg class="w-6 h-6 custom-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#e5e7eb" stroke-width="4"></circle><path fill="#3b82f6" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
                    }
                });
                
                // Create form data with the toggle state
                const formData = new FormData();
                formData.append('show_followed_only', followedToggle.checked ? '1' : '0');
                
                // Save toggle state to server
                fetch('/posts/toggle-followed', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                }).then(response => response.json())
                  .then(data => {
                      // Find active category link and trigger click
                      const activeCategoryLink = document.querySelector('.category-link.active');
                      if (activeCategoryLink) {
                          activeCategoryLink.click();
                      } else {
                          // If no active category, reload current URL with ajax parameter
                          let url = window.location.href;
                          url += (url.includes('?') ? '&' : '?') + 'ajax=1';
                          
                          // Fetch posts via AJAX
                          fetch(url)
                              .then(response => response.text())
                              .then(html => {
                                  // Update all post containers
                                  postsContainers.forEach(container => {
                                      if (container) {
                                          container.innerHTML = html;
                                      }
                                  });
                                  // Setup pagination for AJAX
                                  setupPaginationLinks();
                              })
                              .catch(error => {
                                  console.error('Error:', error);
                                  postsContainers.forEach(container => {
                                      if (container) {
                                          container.innerHTML = '<div class="text-center text-red-500 py-16">Error memuat post</div>';
                                      }
                                  });
                              });
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                  });
            });
        }
    });
    
    // Function to setup pagination links for AJAX - copied from category-tabs.js
    function setupPaginationLinks() {
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                
                // Show loading state in all post containers
                postsContainers.forEach(container => {
                    if (container) {
                        container.innerHTML = '<div class="flex justify-center items-center py-16"><svg class="w-6 h-6 custom-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#e5e7eb" stroke-width="4"></circle><path fill="#3b82f6" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
                    }
                });
                
                // Update URL without page reload
                window.history.pushState({}, '', url);
                
                // Fetch posts via AJAX
                fetch(url + (url.includes('?') ? '&' : '?') + 'ajax=1')
                    .then(response => response.text())
                    .then(html => {
                        // Update all post containers
                        postsContainers.forEach(container => {
                            if (container) {
                                container.innerHTML = html;
                            }
                        });
                        setupPaginationLinks();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        postsContainers.forEach(container => {
                            if (container) {
                                container.innerHTML = '<div class="text-center text-red-500 py-16">Error memuat post</div>';
                            }
                        });
                    });
            });
        });
    }
});