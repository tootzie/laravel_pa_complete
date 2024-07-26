/**
 * Dashboard Analytics
 */

'use strict';

(function () {
    $('#statusDropdown a').on('click', function(){
        var selectedStatus = $(this).data('status');
        var buttonLabel = $(this).text();
        $('#dropdown-status-label').text(buttonLabel);

        $('table tbody tr').each(function(){
            var status = $(this).find('td:nth-last-child(2)').text();
            console.log('status');
            console.log(status);
            if(selectedStatus == 'semua' || status == selectedStatus){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
})();
