$(document).ready(function (e) {

    $(document).on('click', '[data-modal-worker]', function (e) {
        let client_id = $(this).data('worker-id');

        if (client_id) {
            
            add_body_bg();
            $('#modal-worker').addClass('open');
            
        } else {
            alert('Не задан id сотрудника в атрибуте data-worker-id');
        }
    });

    $(document).on('click', '[data-modal-worker-add]', function (e) {
            add_body_bg();
            $('#modal-worker-add').addClass('open');
    });


});