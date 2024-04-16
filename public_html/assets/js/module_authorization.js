// Страница авторизации
$(document).ready(function (e) {
    let is_val = false;

    $('.module-authorization .authorization-form input').on('input', validate_auth_form);

    function validate_auth_form() {
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
    }
    validate_auth_form();

    $(document).on('click', '.sign-in-form .authorization-form__btn', function(e) {
        if (is_val) {
            let formData = new FormData();
            formData.append('login', $('.sign-in-form').find('input[name="email"]').val());
            formData.append('password', $('.sign-in-form').find('input[name="password"]').val());
            formData.append('is_remember', $('.sign-in-form').find('input[name="remember"]').val());

            e.preventDefault();

            xpost_fd(API_V1_URLS.auth.sign_in, formData).then(response => {
                dd(response, response.message ? response.message :'Авторизация прошла успешно');
                
                window.location.href = "/";
            }).catch(response => {
                dd(response, response.message ? response.message : 'Авторизация не удалась. Что-то пошло не так', 'error');
                push(response.message ? response.message : "Авторизация не удалась. Что-то пошло не так", "error", 2000);
            });
        } else {
            push("Заполните все поля!", 'error');
        }
    });

});

// Страница авторизации
$(document).ready(function (e) {
    $(document).on('click', '.recovery-form .authorization-form__btn', function(e) {
        e.preventDefault();
        
        let formData = new FormData();
        formData.append('email', $('.recovery-form').find('input[name="email"]').val());

        xpost_fd(API_V1_URLS.auth.recovery, formData).then(response => {
            let msg = response.message ? response.message :'Авторизация прошла успешно';
            dd(response, msg);

            $('.recovery-form .authorization-form__message').css('display', 'block').removeClass('error').addClass('success');
            $('.recovery-form .authorization-form__message-text').text(msg);
            
            push(msg, "success", 2000);
            
            setTimeout(() => window.location.href = "/", 2500);
        }).catch(response => {
            dd(response, response.message ? response.message : 'Авторизация не удалась. Что-то пошло не так', 'error');
            push(response.message ? response.message : "Авторизация не удалась. Что-то пошло не так", "error", 2000);

            $('.recovery-form .authorization-form__message').css('display', 'block');
            $('.recovery-form .authorization-form__message-text').text(response.message ? response.message : 'Авторизация не удалась. Что-то пошло не так');
        });
    });
});