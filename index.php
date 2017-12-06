<?php
if (count($argv) < 4) {
    exit('参数错误');
}

define('PATH_DIST', $argv[1]);
define('PATH_TEMP', $argv[2]);
define('PATH_SOURCE', $argv[3]);
define('PATH_TEMPLATE', $argv[4]);

require 'function.php';
spl_autoload_register(function ($name) {
    $file = 'library/' . lcfirst(str_replace('\\', '/', $name)) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

Builder::assets();
Render::handle(Builder::traverse());
