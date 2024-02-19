$(document).ready(function (e) {

    $(document).on('click', '[data-modal-client]', function (e) {
        let client_id = $(this).data('client-id');

        if (client_id) {
            
            add_body_bg();
            $('#modal-client').addClass('open');
            
        } else {
            alert('Не задан id клиента в атрибуте data-client-id');
        }
    });

    $(document).on('click', '[data-modal-client-add]', function (e) {
            add_body_bg();
            $('#modal-client-add').addClass('open');
    });


});