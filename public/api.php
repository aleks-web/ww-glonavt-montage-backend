<?php

// Автозагрузка библиотек и собственных классов (psr-4)
include_once dirname(__DIR__) . '/vendor/autoload.php';

use WWCrm\ServiceContainer;

$WWAppContainer = ServiceContainer::getInstance();

dd($WWAppContainer);