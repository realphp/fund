<?php
$fields = D('cms_slide')->getDbFields();
if (!in_array('url', $fields)) {
    $table_name = $db_prefix . "cms_slide";
    $db->execute("
                  ALTER TABLE $table_name
                  ADD url VARCHAR(300) NOT NULL DEFAULT '' COMMENT '跳转链接' AFTER image
                  ");
    $msgs[] = "首页大图添加链接字段修复";
}


$fields = D('cms_single_page')->getDbFields();
if (!in_array('show_in_nav', $fields)) {
    $table_name = $db_prefix . "cms_single_page";
    $db->execute("
                  ALTER TABLE $table_name
                  ADD show_in_nav TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '导航显示' AFTER url
                  ");
    $msgs[] = "单页导航显示控制字段修复";
}


