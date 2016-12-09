<?php
$cfg = array(

    'URL_MODEL' => 3,
    'LOG_TYPE' => 'File',
    'LOG_RECORD' => true,
    'LOG_EXCEPTION_RECORD' => true,
    'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR,WARN,NOTICE',
    'URL_HTML_SUFFIX' => '',

    'LANG_SWITCH_ON' => true,
    'LANG_AUTO_DETECT' => true,
    'LANG_LIST' => 'zh-cn',
    'VAR_LANGUAGE' => 'l',

    'ERROR_MESSAGE' => '页面错误',
    'TMPL_ACTION_ERROR' => 'app/Common/View/Common/dispatch_jump.html',
    'TMPL_ACTION_SUCCESS' => 'app/Common/View/Common/dispatch_jump.html',
    'TMPL_EXCEPTION_FILE' => 'app/Common/View/Common/think_exception.html',

    'COOKIE_HTTPONLY' => true,
    'SESSION_OPTIONS' => array(
        'name' => 'tpx_sid'
    ),

    'DATA_CACHE_SUBDIR' => true,
    'DATA_PATH_LEVEL' => 4,

    'DEFAULT_THEME' => 'default'
);


if (!file_exists($file = './_CFG/db.php')) {
    $file = './_CFG/db.default.php';
}
$cfg = array_merge($cfg, (include $file));


$cfg = array_merge($cfg, (include './_CFG/config.default.php'));
if (file_exists($file = './_CFG/config.php')) {
    $cfg = array_merge($cfg, (include $file));
}

return $cfg;