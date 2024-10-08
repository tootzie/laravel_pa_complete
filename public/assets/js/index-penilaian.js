/**
 * Dashboard Analytics
 */

'use strict';

(function () {

    $(document).ready(function () {
        // Trigger autosave every 2 minutes (120,000 milliseconds)
        setInterval(function () {
            autosave();
        }, 120000); // 2 minutes

        // Autosave function
        function autosave() {
            let formData = $('#penilaianForm').serialize(); // Get all form data
            let csrfToken = $('#penilaianForm input[name="_token"]').val();

            let formArray = $('#penilaianForm').serializeArray();

            $.ajax({
                url: autosaveUrl, // Replace with your autosave route
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Add this line for CSRF protection
                },
                data: formData,
                success: function (response) {
                    $('#autosaveMessage').text('Data tersimpan otomatis pukul ' + new Date().toLocaleTimeString()).addClass('alert alert-success');;
                },
                error: function () {
                    console.error(xhr.responseText); // Log the error details
                    $('#autosaveMessage').text('Penyimpanan otomatis gagal, mohon cek koneksi');
                }
            });
        }
    });

    $('#statusDropdown a').on('click', function(){
        var selectedStatus = $(this).data('status');
        var buttonLabel = $(this).text();
        $('#dropdown-status-label').text(buttonLabel);

        $('table tbody tr').each(function(){
            var status = $(this).find('td:nth-last-child(2)').text();
            if(selectedStatus == 'semua' || status == selectedStatus){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });



    document.getElementById('previewButton').addEventListener('click', function() {
        // Get the form element
        var form = document.getElementById('penilaianForm');

        // Change the form action to the Preview route
        form.action = previewRoute;

        // Submit the form
        form.submit();
    });
})();
