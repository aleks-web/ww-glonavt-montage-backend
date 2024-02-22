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

// Start Добаввление клиента в базу данных
$(document).ready(function (e) {

    $(document).on('click', '#modal-client-add .js-client-add', function (e) {
        
        let create_url = API_V1_URLS.clients.create; // API_V1_URLS - Смотрим в main.js
        let formData = new FormData();

        $('#modal-client-add .input-text, #modal-client-add .select').each(function(i, el) {
            let input = $(this).find('input');

            if (input.val()) {
                formData.append(input.attr('name'), input.val());
            }
        });



        $.ajax({
            url: create_url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
            }
        });
    });
});
// End Добаввление клиента в базу данных