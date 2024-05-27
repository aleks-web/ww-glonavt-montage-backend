<?php

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(realpath(dirname(__DIR__)) . '/.env');