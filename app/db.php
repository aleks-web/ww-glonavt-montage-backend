<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
	"driver" => 'mysql',
    "host" => 'wwserver.beget.tech',
    "database" => 'wwserver_dcrm_gl',
    "username" => 'wwserver_dcrm_gl',
    "password" => '1S4l&ASd',
    "charset" => "utf8",
    "collation" => "utf8_unicode_ci",
    "prefix" => '',
]);
$capsule->bootEloquent();
$capsule->setAsGlobal();