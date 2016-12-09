<?php

namespace Admin\Controller;

use Think\Controller;
use Think\Db;
use Org\Util\String;

class InstallController extends AdminController
{
    protected function _initialize()
    {
        parent::_initialize();
        load('Common.db');

        if (ACTION_NAME != 'backup' && file_exists('./_CFG/install.lock')) {
            $this->error(L('install_repeat_notice'), U('Install/index'), 5);
        }

        define('ADMIN_EMPTY_FRAME', true);

    }

    public function index()
    {
        $this->display();
    }

    public function commonstep1()
    {
        $this->environment_error = 0;
        !($this->writeable_config = is_writable(THINK_PATH . '../_CFG/')) && ($this->environment_error++);
        !($this->writeable_run = is_writable(THINK_PATH . '../_RUN/')) && ($this->environment_error++);
        !($this->writeable_data = is_writable(THINK_PATH . '../data/')) && ($this->environment_error++);
        !($this->dependency_pdo = class_exists('pdo')) && ($this->environment_error++);
        !($this->dependency_pdo_mysql = extension_loaded('pdo_mysql')) && ($this->environment_error++);
        !($this->dependency_file_get_contents = function_exists('file_get_contents')) && ($this->environment_error++);
        !($this->dependency_mb_strlen = function_exists('mb_strlen')) && ($this->environment_error++);
        !($this->dependency_curl = function_exists('curl_init')) && ($this->environment_error++);

        $this->display();
    }

    public function commonstep2()
    {
        $this->display();
    }

    public function commonstep3()
    {
        $data = array();
        foreach (array(
                     'db_type',
                     'db_host',
                     'db_port',
                     'db_name',
                     'db_user',
                     'db_pwd',
                     'db_prefix',
                     'admin_username',
                     'admin_password'
                 ) as $k) {
            $data [$k] = trim(I('post.' . $k));
        }
        $this->dbtest(true);
        if (!$data ['admin_username'] || !$data ['admin_password']) {
            $this->error('Admin username and password required!');
        }

        $config_arr = array();
        $config_arr ['DB_TYPE'] = $data ['db_type'];
        $config_arr ['DB_HOST'] = $data ['db_host'];
        $config_arr ['DB_PORT'] = $data ['db_port'];
        $config_arr ['DB_NAME'] = $data ['db_name'];
        $config_arr ['DB_USER'] = $data ['db_user'];
        $config_arr ['DB_PWD'] = $data ['db_pwd'];
        $config_arr ['DB_PREFIX'] = $data ['db_prefix'];
        file_put_contents('./_CFG/db.php', "<?php\nreturn " . var_export($config_arr, true) . ";");
        foreach ($config_arr as $k => $v) {
            C($k, $v);
        }
        unset ($config_arr);

        $db = Db::getInstance();
        $db_prefix = C('DB_PREFIX');

        // $db->execute ( "DROP TABLE IF EXISTS `${db_prefix}admin_user`" );
        // $db->execute ( "DROP TABLE IF EXISTS `${db_prefix}admin_role`" );
        // $db->execute ( "DROP TABLE IF EXISTS `${db_prefix}admin_node`" );
        // $db->execute ( "DROP TABLE IF EXISTS `${db_prefix}admin_access`" );
        // $db->execute ( "DROP TABLE IF EXISTS `${db_prefix}admin_role_user`" );
        // $db->execute ( "DROP TABLE IF EXISTS `${db_prefix}data_files`" );

        $tables = $db->getTables();
        foreach (array(
                     'admin_user',
                     'admin_role',
                     'admin_node',
                     'admin_access',
                     'admin_role_user',
                     'data_files'
                 ) as $table) {
            if (in_array($db_prefix . $table, $tables)) {
                $this->error("数据表 $db_prefix$table 已经存在!");
            }
        }

        switch (C('DB_TYPE')) {
            case 'mysql' :
                $db->execute("
						CREATE TABLE `${db_prefix}admin_user` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `username` char(16) NOT NULL,
						  `password` char(32) NOT NULL,
						  `password_salt` char(10) NOT NULL,
						  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
						  `reg_ip` bigint(20) NOT NULL DEFAULT '0',
						  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0',
						  `last_login_ip` bigint(20) NOT NULL DEFAULT '0',
						  `last_change_pwd_time` int(10) unsigned NOT NULL DEFAULT '0',
						  `status` tinyint(4) DEFAULT '0' COMMENT '用户状态0正常1锁定',
						  PRIMARY KEY (`id`),
						  UNIQUE KEY `username` (`username`),
						  KEY `status` (`status`)
						) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

                $db->execute("
						CREATE TABLE `${db_prefix}admin_role` (
						  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
						  `name` varchar(20) NOT NULL,
						  `pid` int(6) DEFAULT NULL,
						  `status` tinyint(1) unsigned DEFAULT NULL,
						  `remark` varchar(255) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `pid` (`pid`),
						  KEY `status` (`status`)
						) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

                $db->execute("
						CREATE TABLE `${db_prefix}admin_node` (
							`id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
						  	`name` varchar(20) NOT NULL,
							`title` varchar(50) DEFAULT NULL,
							`status` tinyint(1) DEFAULT '0',
							`remark` varchar(255) DEFAULT NULL,
							`sort` smallint(6) unsigned DEFAULT NULL,
							`pid` smallint(6) unsigned NOT NULL,
							`level` tinyint(1) unsigned NOT NULL,
							PRIMARY KEY (`id`),
							KEY `level` (`level`),
							KEY `pid` (`pid`),
							KEY `status` (`status`),
							KEY `name` (`name`)
						) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

                $db->execute("
						CREATE TABLE `${db_prefix}admin_access` (
							`role_id` smallint(6) unsigned NOT NULL,
						  	`node_id` smallint(6) unsigned NOT NULL,
						  	`level` tinyint(1) NOT NULL,
						  	`module` varchar(50) DEFAULT NULL,
						  	KEY `groupId` (`role_id`),
						  	KEY `nodeId` (`node_id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

                $db->execute("
						CREATE TABLE `${db_prefix}admin_role_user` (
						`role_id` mediumint(9) unsigned DEFAULT NULL,
						`user_id` char(32) DEFAULT NULL,
						KEY `group_id` (`role_id`),
						KEY `user_id` (`user_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

                // data/xxxx/yyyymm/dd/30+
                $db->execute("
						CREATE TABLE `${db_prefix}data_files` (
						  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
						  `uptime` int unsigned NOT NULL DEFAULT 0,
						  `filesize` int unsigned NOT NULL DEFAULT 0,
						  `dir` char(6) NOT NULL,
						  `path` char(40) DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `uptime` (`uptime`),
						  KEY `dir` (`dir`),
						  KEY `path` (`path`)
						) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

                $db->execute("
						CREATE TABLE `${db_prefix}config` (
						  `name` varchar(50) NOT NULL DEFAULT '',
						  `val` TEXT,
						  KEY `name` (`name`)
						) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

                $db->execute("
                    CREATE TABLE `${db_prefix}cms_tag_pool` (
                      `id` INT unsigned NOT NULL AUTO_INCREMENT,
                      `addtime` INT UNSIGNED NOT NULL DEFAULT 0,
                      `updatetime` INT UNSIGNED NOT NULL DEFAULT 0,
                      `cat` VARCHAR(6) NOT NULL,
                      `name` VARCHAR(40) DEFAULT NULL,
                      PRIMARY KEY (`id`),
                      KEY `addtime` (`addtime`),
                      KEY `updatetime` (`updatetime`),
                      KEY `cat` (`cat`),
                      KEY `name` (`name`)
                    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

                $admin = D('AdminUser');
                if ($admin->m_add($data ['admin_username'], $data ['admin_password'], 1) < 0) {
                    $this->error($admin->getError());
                }

                $role = M('AdminRole');
                foreach (array(
                             '超级管理员',
                             '操作员',
                             '网站编辑'
                         ) as $name) {
                    $role->name = $name;
                    $role->status = 1;
                    if (!$role->add()) {
                        $this->error($role->getError());
                    }
                }

                define('ADMIN_PERMISSION_CHECK_IGNORE', true);
                foreach (get_admin_controller('mod') as $controller) {
                    A('Mod' . $controller ['name'])->build($yummy = true);
                }
                foreach (get_admin_controller('cms') as $controller) {
                    A('Cms' . $controller ['name'])->build($yummy = true);
                }

                break;
            default :
                $this->error('Unsupport database type');
        }

        $admin_domain = I('post.admin_domain', 'trim');

        // init config.php file
        tpx_sys_config_set('APP_SUB_DOMAIN_RULES', array(
            $admin_domain => 'Home'
        ));

        // put install lock file
        file_put_contents('./_CFG/install.lock', 'lock');

        //$db
        if (file_exists($file = './app/Common/Custom/install_init_script.php')) {
            include $file;
        }

        // remove _RUN files
        tpx_rm_dir('./_RUN/', false);

        $this->success(L('install_success'), U('Login/index'));
    }

    public function dbtest($forcheck_only = false)
    {
        $data = array();
        foreach (array(
                     'db_type',
                     'db_host',
                     'db_port',
                     'db_name',
                     'db_user',
                     'db_pwd',
                     'db_prefix'
                 ) as $k) {
            $data [$k] = trim(I('post.' . $k));
        }
        switch ($data ['db_type']) {
            case 'mysql' :
                // ob_start ();
                $conn = @mysql_connect($data ['db_host'] . ':' . $data ['db_port'], $data ['db_user'], $data ['db_pwd']);
                if ($conn) {
                    if (@mysql_select_db($data ['db_name'])) {
                        if (!$forcheck_only) {
                            $this->success('数据库链接正常！');
                        }
                    } else {
                        $this->error('服务器连接成功，数据库 ' . $data ['db_name'] . ' 不存在!');
                    }
                } else {
                    $this->error('连接数据库服务器 ' . $data ['db_host'] . ':' . $data ['db_port'] . ' 失败!');
                }
                // $content = ob_get_contents ();
                // ob_end_clean ();

                break;
            default :
                $this->error('Unsupport database type');
        }
    }

    public function backup()
    {
        $db = Db::getInstance();
        if (file_exists($file = './app/Common/Custom/install_backup_script.php')) {
            include $file;
        }
    }

}