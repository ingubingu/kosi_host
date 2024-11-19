document.addEventListener('DOMContentLoaded', function() {

    const addColumnButton = document.getElementById('add-column-button');
    const columnsContainer = document.getElementById('columns-container');
    let columnIndex = 1; // Start from 1 since 0 is already used

    addColumnButton.addEventListener('click', function() {
        const columnInput = document.createElement('div');
        columnInput.className = 'column-input';
        columnInput.innerHTML = `
            <input type="text" name="table[columns][${columnIndex}][name]" placeholder="Column Name" required>
            <select name="table[columns][${columnIndex}][type]" required>
                <option value="INT">INT</option>
                <option value="VARCHAR(255)">VARCHAR(255)</option>
                <option value="TEXT">TEXT</option>
                <option value="DATE">DATE</option>
                <option value="DATETIME">DATETIME</option>
                <option value="BOOLEAN">BOOLEAN</option>
                <!-- Add more types as needed -->
            </select>
            <button type="button" class="remove-column-button">Remove</button>
        `;
        columnsContainer.appendChild(columnInput);
        columnIndex++;
    });

    columnsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-column-button')) {
            event.target.parentElement.remove();
        }
    });

    // Handle form submission via AJAX
    const createTableForm = document.getElementById('create-table-form');
    createTableForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(createTableForm);

        fetch('../handlers/create_table_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const responseMessage = document.getElementById('response-message');
            if (data.success) {
                responseMessage.innerHTML = `<p style="color: green;">${data.message}</p>`;
            } else {
                responseMessage.innerHTML = `<p style="color: red;">${data.error}</p>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});