<?php
if (!defined('THINK_PATH')) {
    exit();
}
define('ADMIN_PERMISSION_CHECK_IGNORE', true);

$err = error_reporting(E_ALL & (~E_NOTICE));
set_error_handler(function () {

});

$db = \Think\Db::getInstance();
$db_prefix = C('DB_PREFIX');
$db_type = C('DB_TYPE');
$tables = $db->getTables();

$msgs = array();

if (file_exists($file = './app/Common/Upgrade/custom.php')) {
    include $file;
}


$table_name = $db_prefix . "cms_tag_pool";
if (!in_array($table_name, $tables)) {
    $db->execute("
						CREATE TABLE `${table_name}` (
						  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
						  `addtime` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '添加时间',
						  `updatetime` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
						  `cat` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '分类',
						  `name` VARCHAR(100) DEFAULT NULL DEFAULT '' COMMENT '名称',
						  PRIMARY KEY (`id`),
						  KEY `addtime` (`addtime`),
						  KEY `updatetime` (`updatetime`),
						  KEY `cat` (`cat`),
						  KEY `name` (`name`)
						) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT '标签池';");
    $msgs [] = '创建cms_tag_pool数据表';
}

$table_name = $db_prefix . "data_files";
if (in_array($table_name, $tables)) {
    $result = $db->query("DESC $table_name");
    if (is_array($result)) {
        $exists = false;
        foreach ($result as $r) {
            if ($r['field'] == 'filesize') {
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            $db->execute("
                        ALTER TABLE `${table_name}`
                            ADD filesize INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '文件大小' AFTER uptime;
                    ");
            $msgs[] = 'data_files添加filesize字段';
        }
    }
}

////////////// 变更节点权限开始 ///////////////

// 取出旧的节点和权限
$admin_access = D('AdminAccess')->select();
if (empty($admin_access)) {
    $admin_access = array();
}
$admin_node = D('AdminNode')->select();
if (empty($admin_node)) {
    $admin_node = array();
}


// 更新新的节点和权限
$db->execute("TRUNCATE TABLE ${db_prefix}admin_node");
$db->execute("TRUNCATE TABLE ${db_prefix}admin_access");


//两处地方
$menus_to_delete = array();
if (!APP_DEV_MODE) {
    $menus_to_delete[] = 'System/cmslist';
    $menus_to_delete[] = 'System/modlist';
    $menus_to_delete[] = 'Administrator/nodelist';
}


$nodes = array();
foreach (get_admin_controller('exportable') as $controller) {
    $controller_name = $controller ['name'];
    $class = "\\Admin\\Controller\\${controller_name}Controller";
    if (property_exists($class, 'export_menu')) {
        foreach ($class::$export_menu as $menus_global) {
            foreach ($menus_global as $controller_title => $menus) {
                if (!isset ($nodes [$controller_name])) {
                    $nodes [$controller_name] = array(
                        'title' => $controller_title,
                        'sub' => array()
                    );
                }
                foreach ($menus as $method => $method_detial) {
                    if (in_array($controller_name . '/' . $method, $menus_to_delete)) {
                        continue;
                    }
                    $nodes [$controller_name] ['sub'] [$method] = $method_detial ['title'];
                    foreach ($method_detial ['hiddens'] as $method_hidden => $method_hidden_title) {
                        $nodes [$controller_name] ['sub'] [$method_hidden] = $method_hidden_title;
                    }
                }
            }
        }
    }
}

$admin_node_info_id_map = array();

$node = M('AdminNode');
$node->name = 'Admin';
$node->title = '_ADMIN_ROOT_';
$node->status = 1;
$node->sort = 0;
$node->pid = 0;
$node->level = 1;
if ($node->add()) {
    $admin_node_info_id_map['Admin'] = $node->getLastInsID();
    foreach ($nodes as $k => $v) {
        $data = array(
            'name' => $k,
            'title' => $v ['title'],
            'status' => 1,
            'sort' => 100,
            'pid' => 1,
            'level' => 2
        );
        $node->create($data);
        $insert_id = $node->add();
        $admin_node_info_id_map['Admin/' . $k] = $node->getLastInsID();
        foreach ($v ['sub'] as $kk => $vv) {
            $data = array(
                'name' => $kk,
                'title' => $vv,
                'status' => 1,
                'sort' => 100,
                'pid' => $insert_id,
                'level' => 3
            );
            $node->create($data);
            $node->add();
            $admin_node_info_id_map['Admin/' . $k . '/' . $kk] = $node->getLastInsID();
        }
    }
} else {
    $msgs[] = '升级$node->add()失败';
}

$admin_node_id_info_map = array();
$admin_node_id_level_map = array();
$admin_node_id_name_map = array();
foreach ($admin_node as &$r) {
    $admin_node_id_field_map[$r['id']] = array('name' => $r['name'], 'pid' => $r['pid']);
}

foreach ($admin_node as &$r) {
    switch ($r['level']) {
        case 3:
            $admin_node_id_info_map[$r['id']] = $admin_node_id_field_map[$admin_node_id_field_map[$r['pid']]['pid']]['name'] . '/' . $admin_node_id_field_map[$r['pid']]['name'] . '/' . $r['name'];
            break;
        case 2:
            $admin_node_id_info_map[$r['id']] = $admin_node_id_field_map[$r['pid']]['name'] . '/' . $r['name'];
            break;
        case 1:
            $admin_node_id_info_map[$r['id']] = $r['name'];
            break;
    }
    $admin_node_id_level_map[$r['id']] = $r['level'];
}

$access = D('AdminAccess');
foreach ($admin_access as &$v) {
    $data = array();
    $data['role_id'] = $v['role_id'];
    $data['node_id'] = $admin_node_info_id_map[$admin_node_id_info_map[$v['node_id']]];
    $data['level'] = $admin_node_id_level_map[$v['node_id']];
    $data['module'] = '';
    $access->add($data);
}

unset($admin_node, $admin_access);
unset($admin_node_id_field_map);
unset($admin_node_id_info_map, $admin_node_id_level_map, $admin_node_id_info_map);

$msgs[] = '重新计算后台管理权限节点';

////////////// 变更节点权限结束 ///////////////
// 初始化所有模块
foreach (get_admin_controller('mod') as $controller) {
    A('Admin/Mod' . $controller ['name'])->build($yummy = true);
}
foreach (get_admin_controller('cms') as $controller) {
    A('Admin/Cms' . $controller ['name'])->build($yummy = true);
}

// 更新缓存
tpx_rm_dir('./_RUN/', false);
if (!file_exists('./_RUN/')) {
    @mkdir('./_RUN/');
}
@file_put_contents('./_RUN/index.html', 'Access Forbidden');

echo '<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>升级提示</title>
</head>
<body>
<div style="margin:0 auto;width:600px;background:#EEE;line-height:2em;font-size:12px;padding:1em;">
<div style="border-bottom:1px solid #CCC;font-size:14px;text-align: center;color:red;">升级提示</div>
<ul>
';
if (!empty($msgs)) {
    foreach ($msgs as $msg) {
        echo "<li>" . $msg . "</li>";
    }

    \Think\Log::write("Upgrade to V" . APP_VERSION . ', ' . join(",", $msgs) . "\r\n", \Think\Log::INFO);
}
echo '
<li>升级版本到 V' . APP_VERSION . '</li>
</ul>
</div>
</body>
</html>';
exit();



