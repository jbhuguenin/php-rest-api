<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 16/07/2017
 * Time: 11:41
 */

spl_autoload_register(function ($class) {

    $prefix = 'Rest\\';
    $base_dir = __DIR__ . '/src/Rest/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});