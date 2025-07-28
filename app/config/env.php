<?php

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();


define("DB_USER", $_ENV["DB_USER"]);
define("DB_PASSWORD", $_ENV["DB_PASSWORD"]);

define("DSN", $_ENV["DSN"]);