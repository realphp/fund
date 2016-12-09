<?php
/*
 * 自动部署拉取代码
 * 用于在 /Watcher/auto_deploy 页面
 *
 */
if (!defined('THINK_PATH')) {
    exit();
}
//echo shell_exec("pwd");
for ($i = 0; $i < 2; $i++) {
    $ret = shell_exec("git pull origin master");
    if (strpos($ret, 'up-to-date') !== false) {
        return true;
    }
}
return false;