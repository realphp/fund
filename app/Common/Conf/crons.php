<?php
$__corns = array(
    'system_guard' => array(
        'system_guard',
        86400,
        0
    )
);

if (file_exists($file = './app/Common/Conf/crons.custom.php')) {
    $__corns = array_merge($__corns, (include $file));
}
return $__corns;
