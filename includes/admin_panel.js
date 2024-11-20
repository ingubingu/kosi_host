document.addEventListener('DOMContentLoaded', function () {
    const adminToggleButton = document.getElementById('adminToggleButton');
    const adminPanel = document.getElementById('adminPanel');

    // Toggle Admin Panel and Load Content
    adminToggleButton?.addEventListener('click', function () {
        if (adminPanel.style.display === 'none' || adminPanel.style.display === '') {
            fetch('../includes/admin_panel.php')
                .then(response => response.text())
                .then(data => {
                    adminPanel.innerHTML = data; // Load content
                    adminPanel.style.display = 'block'; // Show panel
                    addEventListeners(); // Add event listeners to buttons
                })
                .catch(error => console.error('Error loading admin panel:', error));
        } else {
            adminPanel.style.display = 'none'; // Hide panel
        }
    });

    // Real-Time Search in Admin Panel
    adminPanel?.addEventListener('input', function (event) {
        if (event.target.id === 'searchInput') {
            const query = event.target.value;

            fetch('../includes/admin_panel.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `searchQuery=${encodeURIComponent(query)}`,
            })
                .then(response => response.text())
                .then(data => {
                    const userList = document.getElementById('userList');
                    if (userList) {
                        userList.innerHTML = data; // Update user list
                        addEventListeners(); // Add event listeners to buttons
                    }
                })
                .catch(error => console.error('Error updating search results:', error));
        }
    });


    // Event Delegation for Clicks on .user-container Elements
    adminPanel?.addEventListener('click', function (event) {
        const container = event.target.closest('.user-container');
        if (container && adminPanel.contains(container)) {
            // Add click animation class
            container.classList.add('click-animation');

            // Remove the animation class after it completes
            container.addEventListener('animationend', function handleAnimationEnd() {
                container.classList.remove('click-animation');
                container.removeEventListener('animationend', handleAnimationEnd);
            });

            // Create ripple effect
            const ripple = document.createElement('span');
            const diameter = Math.max(container.clientWidth, container.clientHeight);
            const radius = diameter / 2;

            ripple.style.width = ripple.style.height = `${diameter}px`;
            ripple.style.left = `${event.clientX - container.getBoundingClientRect().left - radius}px`;
            ripple.style.top = `${event.clientY - container.getBoundingClientRect().top - radius}px`;
            ripple.classList.add('ripple');

            container.appendChild(ripple);

            ripple.addEventListener('animationend', () => {
                ripple.remove();
            });

        }
    });
    // Initial call to add event listeners
    addEventListeners();
});
