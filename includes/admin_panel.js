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

    function addEventListeners() {
        document.querySelectorAll('.button').forEach(button => {
            button.addEventListener('click', function () {
                const username = this.closest('.user-container').dataset.username;
                const action = this.id.replace('Button', '');
                handleAction(action, username);
            });
        });

        document.querySelectorAll('.user-container').forEach(container => {
            container.addEventListener('click', function () {
                const username = this.dataset.username;
                fetchUserDetails(username);
            });
        });
    }

    function handleAction(action, username) {
        fetch(`../includes/admin_actions.php?action=${action}&username=${username}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`${action} successful for ${username}`);
                location.reload();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function fetchUserDetails(username) {
        fetch(`../includes/user_details.php?username=${username}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showModal(data.user);
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(error => console.error('Error fetching user details:', error));
    }

    function showModal(user) {
        const modal = document.getElementById('userDetailsModal');
        const modalContent = modal.querySelector('.modal-content');
        modalContent.innerHTML = `
            <h2>User Details</h2>
            <p>Username: ${user.username}</p>
            <p>Email: ${user.email}</p>
            <p>Role: ${user.role}</p>
            <button id="closeModalButton">Close</button>
        `;
        modal.style.display = 'block';

        document.getElementById('closeModalButton').addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    // Initial call to add event listeners
    addEventListeners();
});
