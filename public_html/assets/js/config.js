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
    auth: {
        sign_in: "/api_v1/auth/sign_in/",
        recovery: "/api_v1/auth/recovery/",
        logout: "/api_v1/auth/logout/",
    },
    users: {
        create: "/api_v1/users/create/",
        update: "/api_v1/users/update/",
        render: "/api_v1/users/render/",
    },
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
        update: "/api_v1/objects/update/",
        render: "/api_v1/objects/render/",
        create: "/api_v1/objects/create/"
    },
    book_equipments: {
        create: "/api_v1/book-equipment/create/",
        update: "/api_v1/book-equipment/update/",
        render: "/api_v1/book-equipment/render/"
    },
    book_departments: {
        create: "/api_v1/book-departments/create/",
        update: "/api_v1/book-departments/update/",
        delete: "/api_v1/book-departments/delete/",
        render: "/api_v1/book-departments/render/"
    },
    book_posts: {
        create: "/api_v1/book-posts/create/",
        update: "/api_v1/book-posts/update/",
        delete: "/api_v1/book-posts/delete/",
        render: "/api_v1/book-posts/render/"
    },
    book_docs: {
        delete: "/api_v1/book-docs/delete/",
        create: "/api_v1/book-docs/create/",
        render: "/api_v1/book-docs/render/"
    }
};
// End Глобально доступная константа. Содержит ссылки API