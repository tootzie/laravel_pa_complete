document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('.table');
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

    document.querySelectorAll('#tahunDropdown .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const selectedPeriode = this.getAttribute('data-periode');
            document.getElementById('dropdown-peiode-label').innerText = selectedPeriode;
            document.getElementById('selectedPeriode').value = selectedPeriode;
            // Auto-submit the form
            document.getElementById('filterForm').submit();
        });
    });

    document.querySelectorAll('#companyDropdown .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const selectedCompany = this.getAttribute('data-company') == '00' ? 'Semua' : this.getAttribute('data-company');
            document.getElementById('dropdown-company-label').innerText = selectedCompany;
            document.getElementById('selectedCompany').value = selectedCompany;
            // Auto-submit the form
            document.getElementById('filterForm').submit();
        });
    });

    document.querySelectorAll('#statusDropdown .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const selectedStatus = this.getAttribute('data-status-label') == null ? 'Semua' : this.getAttribute('data-status-label');
            const selectedStatusId = this.getAttribute('data-status');

            document.getElementById('dropdown-status-label').innerText = selectedStatus;
            document.getElementById('selectedStatus').value = selectedStatus;
            document.getElementById('selectedStatusId').value = selectedStatusId;

            // Auto-submit the form
            document.getElementById('filterForm').submit();
        });
    });

    document.querySelectorAll('#nilaiDropdown .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const selectedNilai = this.getAttribute('data-nilai') == '00' ? 'Semua' : this.getAttribute('data-nilai');
            document.getElementById('dropdown-nilai-label').innerText = selectedNilai;
            document.getElementById('selectedNilai').value = selectedNilai;
            // Auto-submit the form
            document.getElementById('filterForm').submit();
        });
    });
});
