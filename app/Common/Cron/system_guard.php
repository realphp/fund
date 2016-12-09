<?php
// 删除一个月以前的日志
foreach (list_file(LOG_PATH) as $f) {
    if ($f ['isDir']) {
        foreach (list_file($f ['pathname'] . '/', '*.log') as $ff) {
            if ($ff ['isFile']) {
                if (time() - $ff ['mtime'] > 86400 * 30) {
                    @unlink($ff ['pathname']);
                }
            }
        }
    }
}
// 删除一天以前的临时文件
foreach (list_file(TEMP_PATH) as $f) {
    if ($f ['isFile'] && time() - $f ['mtime'] > 86400 && $f ['filename'] != C('DIR_SECURE_FILENAME')) {
        @unlink($f ['pathname']);
    }
}
// 自动发送日志
if (C('AUTO_SEND_REPORTLOG') && function_exists('curl_init')) {
    $posts = array();
    $logs = array();
    $log_count = 0;
    foreach (list_file(LOG_PATH) as $f) {
        if ($f ['isDir']) {
            foreach (list_file($f ['pathname'] . '/', '*.log') as $ff) {
                if ($ff ['isFile']) {
                    $log_count += 1;
                    $posts ['log_file_' . $log_count] = '@' . $ff ['pathname'];
                    $posts ['log_dir_' . $log_count] = $f['filename'];
                    $logs[] = $ff ['pathname'];
                }
            }
        }
    }

    if ($log_count > 0) {
        $posts['app_domain'] = HTTP_HOST;
        $posts['app_name'] = APP_NAME;
        $posts['app_version'] = APP_VERSION;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://dog.tecmz.com/receive/reportlog");
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response && ($response = @json_decode($response, true))) {
            if (isset($response['code']) && $response['code'] == 200 && isset($response['msg']) && 'OK' == $response['msg']) {
                foreach ($logs as &$r) {
                    @unlink($r);
                }
            }
        }
    }
}