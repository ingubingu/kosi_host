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
                    }
                })
                .catch(error => console.error('Error updating search results:', error));
        }
    });

















});
