<?php
if (count($argv) < 4) {
    exit('参数错误');
}

define('PATH_DIST', $argv[1]);
define('PATH_TEMP', $argv[2]);
define('PATH_SOURCE', $argv[3]);
define('PATH_TEMPLATE', $argv[4]);

require 'function.php';
date_default_timezone_set('PRC');
spl_autoload_register(function ($name) {
    require 'library/' . ucwords(str_replace('\\', '/', $name)) . '.php';
});

Builder::assets();
new Render(Builder::traverse());
