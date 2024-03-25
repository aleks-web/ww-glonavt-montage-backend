$(document).ready(function (e) {
    $('.module-authorization .authorization-form input').on('input', function (e) {
        let is_val = false;

        $('.module-authorization .authorization-form input').each(function (i, e) {
            if ($(this).val() == '') {
                is_val = false;
                return false;
            } else {
                is_val = true;
            }
        });

        if (is_val) {
            $('.module-authorization .authorization-form__btn').removeClass('disable');
        } else {
            $('.module-authorization .authorization-form__btn').addClass('disable');
        }

    });
});