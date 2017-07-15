<?php

use Rest\Server;

require __DIR__ . '/../vendor/autoload.php';

$server = Server::init(require __DIR__ . '/../config/config.php')->run();