document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('.table');
    const headers = table.querySelectorAll('thead th');
    // console.log(headers);

    headers.forEach((header, index) => {
        header.addEventListener('click', () => {
            console.log('header clicked');
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

                // Check if content is numeric
                const aValue = isNaN(aText) ? aText : parseFloat(aText);
                const bValue = isNaN(bText) ? bText : parseFloat(bText);

                return isAscending
                ? (aValue > bValue ? -1 : 1)  // Descending sort
                : (aValue < bValue ? -1 : 1); // Ascending sort
            });

            // Update table with sorted rows
            const tbody = table.querySelector('tbody');
            tbody.innerHTML = ''; // Clear existing rows
            tbody.append(...sortedRows); // Append sorted rows
        });
    });
});
