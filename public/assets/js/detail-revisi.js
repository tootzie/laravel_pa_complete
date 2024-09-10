document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#statusDropdown .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            document.getElementById('dropdown-status-label').innerText = status;
            document.getElementById('selectedStatus').value = status;
        });
    });
});
