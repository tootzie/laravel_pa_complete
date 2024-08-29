document.addEventListener('DOMContentLoaded', function () {
    // const searchInput = document.querySelector('.input-group input');
    // const tableRows = document.querySelectorAll('table tbody tr');

    // searchInput.addEventListener('input', function () {
    //     const query = searchInput.value.toLowerCase();
    //     tableRows.forEach(row => {
    //         const cells = row.querySelectorAll('td');
    //         const isVisible = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(query));
    //         row.style.display = isVisible ? '' : 'none';
    //     });
    // });

    const table = document.querySelector('table');
    const headers = table.querySelectorAll('thead th');

    headers.forEach((header, index) => {
        header.addEventListener('click', () => {
            // Determine the current sorting direction
            const isAscending = header.classList.contains('asc');

            // Remove sorting classes from all headers
            headers.forEach(th => th.classList.remove('asc', 'desc'));

            // Add the appropriate class to the clicked header
            header.classList.add(isAscending ? 'desc' : 'asc');

            // Sort rows
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const sortedRows = rows.sort((a, b) => {
                const aText = a.children[index].textContent.trim();
                const bText = b.children[index].textContent.trim();
                return isAscending
                    ? bText.localeCompare(aText) // Descending sort
                    : aText.localeCompare(bText); // Ascending sort
            });

            // Update table with sorted rows
            const tbody = table.querySelector('tbody');
            tbody.innerHTML = ''; // Clear existing rows
            tbody.append(...sortedRows); // Append sorted rows
        });
    });
});
