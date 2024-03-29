/*
    Start какие-то настрйоки
*/
const WWCrmConfig = {
    debug: true, // Включить режим дебага. Будут показываться сообщения в консоли
};
// End какие-то настрйоки

/*
    Start Глобально доступная константа. Содержит ссылки API
*/
const API_V1_URLS = {
    clients: {
        create: "/api_v1/clients/create/",
        update: "/api_v1/clients/update/",
        create_contact_person: "/api_v1/clients/contacts-persons/create/",
        update_contact_person: "/api_v1/clients/contacts-persons/update/",
        remove_contact_person: "/api_v1/clients/contacts-persons/remove/",
        render: "/api_v1/clients/render/",
    },
    objects: {
        add_new_type_equipment: "/api_v1/objects/add-new-type-equipment/",
        add_new_device: "/api_v1/objects/add-new-device/",
        render: "/api_v1/objects/render/",
    },
    book_equipments: {
        create: "/api_v1/book-equipment/create/",
        update: "/api_v1/book-equipment/update/",
        render: "/api_v1/book-equipment/render/",
    },
};
// End Глобально доступная константа. Содержит ссылки API