<?php

// Автозагрузка библиотек и собственных классов (psr-4)
include_once dirname(__DIR__) . '/vendor/autoload.php';

$crm = require_once realpath(dirname(__DIR__) . '/bootstrap/container.php');

dd($crm);