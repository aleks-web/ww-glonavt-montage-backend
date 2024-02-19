$(document).ready(function (e) {

    $(document).on('click', '[data-modal-application]', function (e) {
        let application_id = $(this).data('application-id');

        if (application_id && e.target.tagName != 'svg' && e.target.tagName != 'use' && !$(e.target).hasClass('td-btn-favorite')) {
            add_body_bg();
            $('#modal-application').addClass('open');
        }
    });

    $(document).on('click', '[data-modal-application-add]', function (e) {
        add_body_bg();
        $('#modal-application-add').addClass('open');
    });

});