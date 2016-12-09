<?php
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    die ('require PHP > 5.3.0 !');
}

define ('HTTP_HOST', strtolower(isset ($_SERVER ['HTTP_HOST']) ? $_SERVER ['HTTP_HOST'] : 'unknown'));

if (file_exists('./_CFG/debug.lock') || !file_exists('./_CFG/install.lock')) {
    define ('APP_DEBUG', true);
    define ('DB_DEBUG', true);
    define ('APP_DEV_MODE', true);
} else {
    define ('APP_DEBUG', false);
    define ('DB_DEBUG', false);
    define ('APP_DEV_MODE', false);
}


if (file_exists($file = './_CFG/version.php')) {
    include $file;
} else {
    define ('APP_VERSION', '1.0.0');
    define ('APP_NAME', 'TPX');
    define ('STATIC_RES_HASH', time());
}
unset($file);