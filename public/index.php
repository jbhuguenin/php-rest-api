<?php

require __DIR__ . '/../autoloader.php';

use Rest\Server;


$server = Server::init(require __DIR__ . '/../config/config.php')->run();