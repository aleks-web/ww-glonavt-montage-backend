<?php

/*
    Последовательность должна быть относительно связей таблиц
*/

// Подключаем миграцию
include_once __DIR__ . '/Migrations/Organizations.php'; // Организации / Клиенты
include_once __DIR__ . '/Migrations/OrgContactsPersons.php'; // Контактные персоны
include_once __DIR__ . '/Migrations/Objects.php'; // Объекты