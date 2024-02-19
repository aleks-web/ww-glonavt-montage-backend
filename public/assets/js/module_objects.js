$(document).ready(function (e) {

    $(document).on('click', '[data-modal-object]', function (e) {
        let object_id = $(this).data('object-id');

        if (object_id) {
            
            add_body_bg();
            $('#modal-object').addClass('open');
            
        } else {
            alert('Не задан id объекта в атрибуте data-object-id');
        }
    });

    $(document).on('click', '[data-modal-object-add]', function (e) {
            add_body_bg();
            $('#modal-object-add').addClass('open');
    });


});