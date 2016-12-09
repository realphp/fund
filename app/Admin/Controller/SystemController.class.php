<?php

namespace Admin\Controller;

use Ext\PclZip;
use Org\Net\Http;
use Org\Util\String;
use Think\Db;
use Think\Storage;

class SystemController extends AdminController
{
    static $export_menu = array(
        'system' => array(
//            '系统维护' => array(
//                'cmslist' => array(
//                    'title' => '内容模型',
//                    'hiddens' => array()
//                ),
//                'modlist' => array(
//                    'title' => '系统模块',
//                    'hiddens' => array()
//                ),
//                'security' => array(
//                    'title' => '系统安全',
//                    'hiddens' => array()
//                ),
//            ),
            '文件管理' => array(
                'filelist' => array(
                    'title' => '文件列表',
                    'hiddens' => array(
                        'filehandle' => '文件管理'
                    )
                ),
                'clean' => array(
                    'title' => '系统清理',
                    'hiddens' => array(
                        'info' => '系统信息',
                        'uploadhandle' => '文件上传',
                        'maintain' => '日常维护',
                        'downloader' => '下载文件',
                        'upgrade' => '系统升级'
                    )
                )
            )
        ),
        '__HOME__' => array(
            '基本管理' => array(
                'profile' => array(
                    'title' => '个人信息',
                    'hiddens' => array(
                        'changepwd' => '修改密码'
                    )
                )
            )
        )
    );


    public function china_district()
    {
        $pid = I('post.pid', 0, 'intval');
        $select_level = I('post.select_level', '', 'intval');
        $init_value = I('post.init_value', 0, 'intval');

        $m = D('ChinaDistrict');

        $times = 1;

        if ($init_value) {

            $cats = array();

            do {

                $one = $m->field('id,name,pid')->find($init_value);

                if (empty($one)) {
                    break;
                }

                $list = $m
                    ->order('sort ASC')
                    ->field('id,name')
                    ->where(array('pid' => $one['pid']))
                    ->select();
                if (empty($list)) {
                    break;
                }

                $ret = array();
                foreach ($list as &$r) {
                    $ret [] = array(
                        'value' => $r['id'],
                        'title' => htmlspecialchars($r['name']),
                        'selected' => ($init_value == $r['id'])
                    );
                }
                $cats[] = $ret;

                $init_value = $one['pid'];

                $times++;

            } while ($init_value > 0 && $times < 5);

            $list_ret = array_reverse($cats);


        } else {

            $list = $m
                ->order('sort ASC')
                ->field('id,name')
                ->where(array('pid' => $pid))
                ->select();
            $list_ret = array();
            if (!empty($list)) {
                foreach ($list as &$r) {
                    $list_ret [] = array(
                        'value' => $r['id'],
                        'title' => htmlspecialchars($r['name'])
                    );
                }
            }

            if ($pid) {

                $one = D('ChinaDistrict')->field('level,pid,name')->find($pid);
                if (!empty($one)) {

                    $level = $one['level'];

                    $id = $one['pid'];
                    $times = 1;
                    while ($one['pid'] != 0 && !empty($one) && $times < 5) {
                        $one_new = D('ChinaDistrict')->field('pid,name')->find($id);
                        if (empty($one_new)) {
                            break;
                        }
                        $id = $one['pid'];
                        $one = $one_new;
                        $times++;
                    }

                    /*
                    if (!empty($one)) {
                        if (in_array($one['name'], array(
                            '北京市',
                            '重庆市',
                            '上海市',
                            '香港特别行政区',
                            '澳门特别行政区',
                        ))) {
                            $level++;
                        }
                    }
                    */

                    if ($level >= $select_level) {
                        $list_ret = array();
                    }
                }
            }

        }

        $this->ajaxReturn(array(
            'status' => 1,
            'list' => $list_ret
        ));
    }


    public function clean($action = '')
    {
        switch ($action) {
            case 'file' :
                $db = Db::getInstance();
                $db_prefix = C('DB_PREFIX');
                $tables = array();
                $tables [] = '_system_init_';
                foreach ($db->getTables() as $t) {
                    if (strpos($t, $db_prefix) === 0) {
                        $t = substr($t, strlen($db_prefix));
                        if (!in_array($t, array(
                            'admin_access',
                            'admin_node',
                            'admin_role',
                            'admin_role_user',
                            'admin_user',
                            'data_files',
                            'member_bind',
                            'member_follow',
                            'wechat_user'
                        ))
                        ) {
                            $tables [] = $t;
                        }
                    }
                }
                $_SESSION ['admin_used_res_file'] = array();
                $this->ajaxReturn(array(
                    'ok' => 1,
                    'data' => $tables
                ));
                break;
            case 'file_find_res' :
                $table = I('post.table', '', 'trim');
                $db = Db::getInstance();
                $db_prefix = C('DB_PREFIX');
                if ($table == '_system_init_') {
                    // TODO StorageDriver=='file'
                    $files_res_exists = array();
                    $files_no_record = array();
                    foreach (array(
                                 'file',
                                 'image',
                                 'video'
                             ) as $dir) {
                        // \data\file\201502\27\xxx.jpg
                        foreach (list_file('data/' . $dir . '/') as $Ym) {
                            if ($Ym ['isDir']) {
                                foreach (list_file($Ym ['pathname'] . '/') as $d) {
                                    if ($d ['isDir']) {
                                        foreach (list_file($d ['pathname'] . '/') as $f) {
                                            $files_res_exists [$dir . '|' . $Ym ['filename'] . '/' . $d ['filename'] . '/' . $f ['filename']] = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $datas = D('DataFiles')->select();
                    if (is_array($datas)) {
                        foreach ($datas as &$d) {
                            $f = $d ['dir'] . '|' . $d ['path'];
                            if (isset ($files_res_exists [$f])) {
                                unset ($files_res_exists [$f]);
                            }
                        }
                    }
                    $files = array();
                    foreach ($files_res_exists as $d => $_v) {
                        $files [] = $d;
                        $a = explode('|', $d);
                        D('DataFiles')->add(array(
                            'dir' => $a [0],
                            'path' => $a [1],
                            'uptime' => 0
                        ));
                    }
                    $this->ajaxReturn(array(
                        'ok' => 1,
                        'data' => $files
                    ));
                } else {
                    if (!in_array($db_prefix . $table, $db->getTables())) {
                        $this->ajaxReturn(array(
                            'ok' => 0,
                            'data' => '不存在数据表' . $table
                        ));
                    }
                    $datas = D($table)->select();
                    if (is_array($datas)) {
                        foreach ($datas as &$d) {
                            foreach ($d as $field => &$dd) {
                                preg_match_all('/data\\/([a-z]+\\/[0-9]{6}\\/[0-9]{2}\\/[0-9]+_[a-z0-9]+_[0-9]+\\.[a-z0-9]+)/i', $dd, $mat);
                                foreach ($mat [1] as &$f) {
                                    $_SESSION ['admin_used_res_file'] [$f] = $table . ':' . $field;
                                }
                            }
                        }
                    }
                    $this->ajaxReturn(array(
                        'ok' => 1
                    ));
                }
                break;
            case 'file_filter_res' :

                if (!isset ($_SESSION ['admin_used_res_file'])) {
                    $this->ajaxReturn(array(
                        'ok' => 0,
                        'data' => '没有找到资源文件列表'
                    ));
                }
                $files_unused = array();
                $datas = D('DataFiles')->select();
                if (is_array($datas)) {
                    foreach ($datas as &$d) {
                        $f = $d ['dir'] . '/' . $d ['path'];
                        if (isset ($_SESSION ['admin_used_res_file'] [$f])) {
                            unset ($_SESSION ['admin_used_res_file'] [$f]);
                        } else {
                            $files_unused [] = array(
                                'id' => $d ['id'],
                                'name' => $f,
                                'uptime' => date('Y-m-d H:i:s', $d ['uptime'])
                            );
                        }
                    }
                }
                $this->ajaxReturn(array(
                    'ok' => 1,
                    'data' => $files_unused
                ));
                break;
            case 'file_delete_xs' :
                foreach (explode(',', I('post.ids', '', 'trim')) as $id) {
                    $id = intval($id);
                    $d = D('DataFiles')->find($id);
                    if (!empty ($d)) {
                        safe_delete_storage_file('data/' . $d ['dir'] . '/' . $d ['path']);
                    }
                }
                $this->ajaxReturn(array(
                    'ok' => 1
                ));
                break;
            default :

                $this->display();
        }
    }

    private function security_filefingergenerate($dir = '', $prefix = '')
    {
        static $allow_file_exts = array(
            'php' => true,
            'js' => true,
            'html' => true,
            'htm' => true
        );
        $file_arrs = array();
        foreach (list_file($dir) as $file) {
            if ($file ['isDir']) {
                $file_arrs = array_merge($file_arrs, $this->security_filefingergenerate($file ['pathname'] . '/', $prefix . $file ['filename'] . '/'));
            } else if ($file ['isFile']) {
                if (isset ($allow_file_exts [$file ['ext']])) {
                    $file_saved = $prefix . str_replace('\\', '/', $file ['filename']);
                    $file_arrs [] = array(
                        $file_saved,
                        md5_file($file ['pathname'])
                    );
                }
            }
        }
        return $file_arrs;
    }

    public function security($action = '', $file = '')
    {
        $security_dir = './data/security/';
        switch ($action) {
            case 'check' :
                $md5_file = null;
                foreach (list_file($security_dir, '*.finger') as $f) {
                    if (md5($f ['filename']) == $file) {
                        $md5_file = $f ['pathname'];
                        $security_file = $security_dir . $f ['filename'];
                        break;
                    }
                }
                if (null != $md5_file) {
                    if (!file_exists($md5_file) || !is_file($md5_file)) {
                        $this->error('Finger file not exists !');
                        return;
                    }
                    $lines = explode("\n", file_get_contents($md5_file));
                    if (count($lines) < 3) {
                        $this->error('Finger file error 1 !');
                        return;
                    }
                    if (!preg_match('/^GENE: TPX V.*?$/', $lines [0]) || !preg_match('/^TIME: \\d+\\-\\d+\\-\\d+ \\d+:\\d+:\\d+$/', $lines [1]) || !preg_match('/^ROOT: ([\\/\\.]*)/', $lines [2])) {
                        $this->error('Finger file error 2 !');
                        return;
                    }
                    $finger_file_root = trim(substr($lines [2], 5));
                    $basedir = str_replace('\\', '/', rtrim(realpath($finger_file_root), '\\/')) . '/';
                    unset ($lines [0], $lines [1], $lines [2]);

                    $error_msgs = array();
                    $file_should_exists = array();
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if ($line) {
                            $l = explode('|', $line);
                            if (count($l) == 2) {
                                $file = trim($l [1]);
                                $md5 = trim($l [0]);
                                $file_should_exists [$file] = $md5;
                                if (file_exists($filename = $basedir . $file)) {
                                    if ($md5 != md5_file($filename)) {
                                        $error_msgs [] = '文件被篡改 : ' . $file;
                                    }
                                } else {
                                    $error_msgs [] = '缺少文件 : ' . $file;
                                }
                            } else {
                                $error_msgs [] = '错误行 : ' . $line;
                            }
                        }
                    }

                    $this->security_file = $security_file;
                    $this->error_msgs = $error_msgs;
                    $this->finger_file_root = $finger_file_root;
                    $this->display('System:security_check');
                }
                break;
            case 'delete' :
                foreach (list_file($security_dir, '*.finger') as $f) {
                    if (md5($f ['filename']) == $file) {
                        @unlink($f ['pathname']);
                    }
                }
                $this->redirect('System/security');
                break;
            case 'generate' :
                if (!file_exists($security_dir)) {
                    @mkdir($security_dir);
                }
                $filename = $security_dir . 'file_finger_' . date('YmdHi') . '_' . String::randString(10) . '.finger';
                $f = fopen($filename, 'w');
                fwrite($f, "GENE: TPX V" . THINK_VERSION . "\n");
                fwrite($f, "TIME: " . date('Y-m-d H:i:s') . "\n");
                fwrite($f, "ROOT: \n");
                $files_md5 = array();
                foreach (array(
                             '_CFG',
                             '_TP',
                             'app',
                             'asserts'
                         ) as $dir) {
                    foreach ($this->security_filefingergenerate('./' . $dir . '/', $dir . '/') as $file_md5) {
                        $files_md5 [] = $file_md5;
                        fwrite($f, $file_md5 [1] . '|' . $file_md5 [0] . "\n");
                    }
                }
                fclose($f);
                $this->files_md5 = $files_md5;
                $this->filename = $filename;
                $this->display('System:security_generate');

                break;
            default :
                if (!file_exists($security_dir)) {
                    @mkdir($security_dir);
                }
                $this->finger_files = list_file($security_dir, '*.finger');
                $this->display();
        }
    }

    private function remove_dir($dir, $time_thres = -1)
    {
        foreach (list_file($dir) as $f) {
            if ($f ['isDir']) {
                $this->remove_dir($f ['pathname'] . '/');
            } else if ($f ['isFile'] && $f ['filename'] != C('DIR_SECURE_FILENAME')) {
                if ($time_thres == -1 || $f ['mtime'] < $time_thres) {
                    @unlink($f ['pathname']);
                }
            }
        }
    }

    public function maintain($action = '')
    {

        // 文件说明
        // Cache : 存储所有模板编译后的文件
        // Data : 存储上传临时文件
        // Logs : 存储系统运行日志文件
        // Temp : 存储缓存
        switch ($action) {


            case 'clear_cache' :
                $this->remove_dir(TEMP_PATH);
                $this->remove_dir(CACHE_PATH);
                $this->remove_dir(DATA_PATH, time() - 24 * 3600);
                file_exists($file = RUNTIME_PATH . 'common~runtime.php') && @unlink($file);

                $this->success(L('operation_success'));
                break;

            case 'analysis_log':
            case 'download_log' :
            case 'view_log':
                $logs = array();
                foreach (list_file(LOG_PATH) as $f) {
                    if ($f ['isDir']) {
                        foreach (list_file($f ['pathname'] . '/', '*.log') as $ff) {
                            if ($ff ['isFile']) {
                                $spliter = '==========================';
                                $logs [] = $spliter . '  ' . $f ['filename'] . '/' . $ff ['filename'] . '  ' . $spliter . "\n\n" . file_get_contents($ff ['pathname']);
                            }
                        }
                    }
                }
                if ('download_log' == $action) {
                    force_download_content('log_' . date('Ymd_His') . '.log', join("\n\n\n\n", $logs));
                } else if ('analysis_log' == $action) {
                    // 分析攻击 ERR: 无法加载模块:DevInfo
                    //TODO
                } else {
                    echo '<pre>' . htmlspecialchars(join("\n\n\n\n", $logs)) . '</pre>';
                }
                break;


            case 'clear_log' :
                $this->remove_dir(LOG_PATH);
                $this->success(L('operation_success'));
                break;
        }
    }

    public function changepwd()
    {
        if (IS_POST) {
            $password_old = I('post.password-old');
            $password_new = I('post.password-new');
            $password_repeat = I('post.password-repeat');
            if (!$password_old || !$password_new) {
                $this->error('Password Empty');
            }
            if ($password_new != $password_repeat) {
                $this->error(L('password_repat_not_equal'));
            }

            $user = D('AdminUser');
            $user_data = $user->find(ADMIN_UID);
            if (encrypt_password($password_old, $user_data ['password_salt']) == $user_data ['password']) {
                $data = array();
                $data ['id'] = ADMIN_UID;
                $data ['password_salt'] = String::randString(10);
                $data ['password'] = encrypt_password($password_new, $data ['password_salt']);
                $data ['last_change_pwd_time'] = time();

                $user->save($data);
                $this->success(L('password_change_success'), U('Login/out'));

            } else {
                $this->error(L('password_old_incorrect'));
            }

            return;
        }
        $this->display();
    }

    public function profile()
    {
        $nodes = D('AdminNode')->order('sort asc')->select();
        $this->data_nodes = node_merge($nodes);

        $user = D('AdminUser');
        $this->data_user = $user->find(ADMIN_UID);

        $data = $user->relation('roles')->find(ADMIN_UID);
        $roleids = array();
        foreach ($data ['roles'] as $r) {
            $roleids [] = $r ['id'];
        }
        $accesses = array();
        if (!empty ($roleids)) {
            foreach (M('AdminAccess')->where(array(
                'role_id' => array(
                    'IN',
                    $roleids
                )
            ))->select() as $a) {
                $accesses [] = $a ['node_id'];
            }
        }
        $this->data_accesses = $accesses;
        $this->data_access_is_super = (ADMIN_UID == '1');

        $this->display();
    }

    public function info()
    {
        $this->system_safe = true;

        $this->danger_mode_debug = file_exists('./_CFG/debug.lock');
        if ($this->danger_mode_debug) {
            $this->system_safe = false;
        }

        // $this->danger_file_install = file_exists('./app/Admin/Controller/InstallController.class.php');
        $this->danger_file_install = false;

        $this->danger_file_publish = file_exists('./app/Admin/Controller/PublishController.class.php');
        if ($this->danger_file_publish) {
            $this->system_safe = false;
        }
        $this->danger_file_admin = file_exists('./admin.php');
        if ($this->danger_file_admin) {
            $this->system_safe = false;
        }

        $this->weak_setting_db_password = false;
        $weak_pwd_reg = array(
            '/^[0-9]{0,6}$/',
            '/^[a-z]{0,6}$/',
            '/^[A-Z]{0,6}$/'
        );
        foreach ($weak_pwd_reg as $reg) {
            if (preg_match($reg, C('DB_PWD'))) {
                $this->weak_setting_db_password = true;
                break;
            }
        }
        if ($this->weak_setting_db_password) {
            $this->system_safe = false;
        }
        $this->weak_setting_admin_password = session('admin_weak_pwd');
        if ($this->weak_setting_admin_password) {
            $this->system_safe = false;
        }
        $this->weak_setting_admin_last_change_password = (session('admin_last_change_pwd_time') < time() - 3600 * 24 * 30);
        if ($this->weak_setting_admin_last_change_password) {
            $this->system_safe = false;
        }

        $log_size = 0;
        $log_file_cnt = 0;
        foreach (list_file(LOG_PATH) as $f) {
            if ($f ['isDir']) {
                foreach (list_file($f ['pathname'] . '/', '*.log') as $ff) {
                    if ($ff ['isFile']) {
                        $log_size += $ff ['size'];
                        $log_file_cnt++;
                    }
                }
            }
        }
        $crons = array();
        if (file_exists($file = RUNTIME_PATH . '~crons.php')) {
            $crons = (include $file);
            $times = array(
                L('second'),
                L('minute'),
                L('hour'),
                L('day')
            );
            foreach ($crons as &$v) {
                $v [2] = date('Y-m-d H:i:s', $v [2] - 24 * 2600);
                if ($v [1] >= 24 * 3600) {
                    $v [1] = sprintf("%.1f", $v [1] / 3600 / 24) . L('day');
                } else if ($v [1] >= 3600) {
                    $v [1] = sprintf("%.1f", $v [1] / 3600) . L('hour');
                } else if ($v [1] >= 60) {
                    $v [1] = sprintf("%.1f", $v [1] / 60) . L('minute');
                } else {
                    $v [1] = sprintf("%d", $v [1]) . L('second');
                }
            }
        }
        $this->crons = $crons;
        $this->log_size = $log_size;
        $this->log_file_cnt = $log_file_cnt;

        $this->display();
    }

    public function cmslist()
    {
        $this->mods = get_admin_controller('cms');
        $this->display();
    }

    public function modlist()
    {
        $this->mods = get_admin_controller('mod');
        $this->display();
    }

    public function filelist()
    {
        $m = D('DataFiles');

        if (IS_POST) {

            $current = I('post.current', 1, 'intval');
            $rowCount = I('post.rowCount', 10, 'intval');
            $sort = I('post.sort');
            $searchPhrase = I('post.searchPhrase');

            $files = D('DataFiles');

            // pre process
            $where = array();
            if ($searchPhrase) {
                $where ['path'] = array(
                    'LIKE',
                    "%$searchPhrase%"
                );
            }
            $order = null;
            foreach ($sort as $f => $d) {
                $order = "$f $d";
            }
            if (empty ($order)) {
                $order = 'id DESC';
            }

            // get info
            $total = $files->where($where)->count();
            if ($order) {
                $files->order($order);
            }
            $data = array();
            foreach ($files->where($where)->page($current, $rowCount)->select() as $v) {
                $data [] = array(
                    'id' => $v ['id'],
                    'fullpath' => $v ['dir'] . '/' . $v ['path'],
                    'filesize' => byte_format($v['filesize']),
                    'uptime' => date('Y-m-d H:i:s', $v ['uptime'])
                );
            }
            // print_r($data);
            $json = array(
                'current' => $current,
                'rowCount' => $total > $rowCount ? $rowCount : $total,
                'total' => $total,
                'rows' => $data
            );
            $this->ajaxReturn($json);
        }

        $this->display();
    }

    public function filehandle($action = '')
    {
        $id = intval($id);
        $files = D('DataFiles');
        switch ($action) {
            case 'delete' :
                $ids = array();
                foreach (explode(',', I('post.ids', '', 'trim')) as $id) {
                    $id = intval($id);
                    if ($id) {
                        $ids [] = $id;
                    }
                }

                if (!empty ($ids)) {
                    foreach ($files->field('dir,path')->where(array(
                        'id' => array(
                            'IN',
                            $ids
                        )
                    ))->select() as $r) {
                        $path = 'data/' . $r ['dir'] . '/' . $r ['path'];
                        safe_delete_storage_file($path);
                    }
                }

                $files->delete(join(',', $ids));
                $this->success('OK');

                break;
            default :
                $this->error(L('error_request'));
        }
    }

    public function downloader($f = '', $action = '')
    {
        define ('ADMIN_EMPTY_FRAME', true);


        $fs = explode('|', hex2bin($f));
        $filepath = isset($fs[0]) ? $fs[0] : '';
        $filename = isset($fs[1]) ? $fs[1] : '';

        if (!preg_match('/^\\d+_[a-z]+_\\d+\\.[a-z]+$/i', $filepath)) {
            $this->error('Error file path');
        }

        if (!file_exists(upload_temp_dir_get() . $filepath)) {
            $this->error('File not exists');
        }


        switch ($action) {
            case 'do':
                header("Content-Type: application/force-download");
                header("Content-Disposition: attachment; filename=" . $filename);
                echo file_get_contents(upload_temp_dir_get() . $filepath);
                break;
            default:
                $this->data_f = $f;
                $this->data_filename = $filename;
                $this->display();
        }
    }


    public function upgrade($action = '')
    {
        // 初次访问请求 /system/upgrade?action=init
        // 返回$this->success("msg")会提示，程序会自动请求当前 /system/upgrade
        // 返回$this->success("ok")表示升级完成，程序会自动注销当前登录
        switch ($action) {
            case 'init':
                if (!C('TPX_UPGRADE_URL')) {
                    $this->error('升级链接不存在');
                }
                $content = @file_get_contents(sprintf(C('TPX_UPGRADE_URL'), bin2hex(APP_VERSION)));
                if (!$content) {
                    $this->error('获取升级信息失败');
                }
                $json = @json_decode($content, true);
                if (isset($json['code']) && $json['code'] == 0 && isset($json['upgrade_package'])) {
                    $_SESSION['tpx_upgrade_package'] = $json['upgrade_package'];
                    $_SESSION['tpx_upgrade_step'] = 'download';
                    $this->success('获取升级包信息成功，下载升级包...');
                } else {
                    if (isset($json['msg'])) {
                        $this->error($json['msg']);
                    }
                }
                $this->error('获取升级信息失败，请尝试手动升级');
                break;
            default:
                switch (I('session.tpx_upgrade_step', '')) {
                    case 'download':
                        $upgrade_package = I('session.tpx_upgrade_package', '');
                        if ($upgrade_package && preg_match('/^http:\\/\\/www\\.tecmz\\.com\\/.*?\\/.*?\\.zip/i', $upgrade_package)) {
                            $filename = substr($upgrade_package, strrpos($upgrade_package, '/') + 1);
                            $local = upload_temp_dir_get() . $filename;
                            @mkdir(upload_temp_dir_get(), 0777, true);
                            Http::curlDownload($upgrade_package, $local);
                            if (!file_exists($local)) {
                                $this->error('下载升级包失败');
                            } else {
                                $_SESSION['tpx_upgrade_package'] = $local;
                                $_SESSION['tpx_upgrade_step'] = 'unpack';
                                $this->success('下载升级包成功，准备解压...');
                            }
                        } else {
                            $this->error('升级包路径为空');
                        }
                        break;
                    case 'unpack':
                        $upgrade_package = I('session.tpx_upgrade_package', '');
                        $upgrade_package_unpack_dir = substr($upgrade_package, 0, strlen($upgrade_package) - 4) . '/';
                        if (!$upgrade_package || !$upgrade_package_unpack_dir) {
                            $this->error('升级文件包为空');
                        }
                        $msg = PclZip::unzip_dir($upgrade_package, $upgrade_package_unpack_dir);
                        if (true !== $msg) {
                            $this->error('解压升级文件错误:' . $msg);
                        }
                        // 复制当前文件到目标文件
                        tpx_copy_dir($upgrade_package_unpack_dir, './', '.BK' . date('YmdHis', time()));
                        // 清空缓存
                        tpx_rm_dir('./_RUN', true);
                        unset($_SESSION['tpx_upgrade_package']);
                        unset($_SESSION['tpx_upgrade_step']);
                        $this->success('ok');
                        break;
                    default:
                        $this->error('未知的升级步骤');
                }

        }
    }


    public function uploadhandle($action = '')
    {
        // 上传说明：
        // 考虑到未来存储，上传的临时数据在_RUN/Temp（TEMP_PATH=./_RUN/Temp）
        // 添加成功后，所有数据传送到 data/*中
        // 注意data/中的所有数据都应该使用Storage驱动来操作，方便后期移植
        $config = array(

            // 上传图片配置项
            'imageActionName' => 'uploadimage',
            'imageFieldName' => 'upfile',
            'imageMaxSize' => C('ADMIN_UPLOAD.IMAGE_MAX_SIZE'),
            'imageAllowFiles' => C('ADMIN_UPLOAD.IMAGE_ALLOW_EXT'),
            'imageCompressEnable' => true,
            'imageCompressBorder' => 1600,
            'imageInsertAlign' => 'none',
            'imageUrlPrefix' => __ROOT__ ? __ROOT__ . '/' : '',

            // 涂鸦图片上传配置项
            'scrawlActionName' => 'uploadscrawl',
            'scrawlFieldName' => 'upfile',
            'scrawlMaxSize' => C('ADMIN_UPLOAD.SCRAWL_MAX_SIZE'),
            'scrawlUrlPrefix' => __ROOT__ ? __ROOT__ . '/' : '',
            'scrawlInsertAlign' => 'none',

            // 截图工具上传，IE可以使用
            'snapscreenActionName' => 'uploadimage',
            'snapscreenUrlPrefix' => __ROOT__ ? __ROOT__ . '/' : '',
            'snapscreenInsertAlign' => 'none',

            // 抓取远程图片配置
            'catcherLocalDomain' => array(), // 忽略的域名 img.baidu.com
            'catcherActionName' => 'catchimage',
            'catcherFieldName' => 'source',
            'catcherUrlPrefix' => __ROOT__ ? __ROOT__ . '/' : '',
            'catcherMaxSize' => C('ADMIN_UPLOAD.CATCHER_MAX_SIZE'),
            'catcherAllowFiles' => C('ADMIN_UPLOAD.CATCHER_ALLOW_EXT'),

            // 上传视频配置
            'videoActionName' => 'uploadvideo',
            'videoFieldName' => 'upfile',
            'videoUrlPrefix' => __ROOT__ ? __ROOT__ . '/' : '',
            'videoMaxSize' => C('ADMIN_UPLOAD.VIDEO_MAX_SIZE'),
            'videoAllowFiles' => C('ADMIN_UPLOAD.VIDEO_ALLOW_EXT'),

            // 上传文件配置
            'fileActionName' => 'uploadfile',
            'fileFieldName' => 'upfile',
            'fileUrlPrefix' => __ROOT__ ? __ROOT__ . '/' : '',
            'fileMaxSize' => C('ADMIN_UPLOAD.FILE_MAX_SIZE'),
            'fileAllowFiles' => C('ADMIN_UPLOAD.FILE_ALLOW_EXT'),

            // 列出指定目录下的图片
            'imageManagerActionName' => 'listimage',
            'imageManagerUrlPrefix' => __ROOT__ ? __ROOT__ . '/' : '',
            'imageManagerUrlPrefixPreview' => __ROOT__ . '/',
            'imageManagerListSize' => 20,
            'imageManagerInsertAlign' => 'none',
            'imageManagerAllowFiles' => C('ADMIN_UPLOAD.IMAGE_LIST_EXT'),

            // 列出指定目录下的文件
            'fileManagerActionName' => 'listfile',
            'fileManagerUrlPrefix' => __ROOT__ ? __ROOT__ . '/' : '',
            'fileManagerUrlPrefixPreview' => __ROOT__ . '/',
            'fileManagerListSize' => 20,
            'fileManagerAllowFiles' => C('ADMIN_UPLOAD.FILE_LIST_EXT')
        );

        if ('config' == $action) {
            $this->ajaxReturn($config);
        } else {
            $ret = array(
                'state' => '',
                'url' => '',
                'title' => '',
                'original' => '',
                'type' => '',
                'size' => 0
            );


            $upload_dir = upload_temp_dir_get();
            if (!file_exists($upload_dir)) {
                mkdir(upload_temp_dir_get(), 0777, true);
            }

            $up = new \Think\Upload ();
            $up->saveName = upload_temp_file_get();
            $up->replace = true;
            $up->subName = '';
            $up->rootPath = $upload_dir;

            switch ($action) {
                case 'listfile' :
                case 'listimage' :
                    $mapping = array(
                        'listfile' => 'file',
                        'listimage' => 'image'
                    );

                    $sret = (array(
                        "state" => "no match file",
                        "list" => array(),
                        "start" => 0,
                        "total" => 0
                    ));

                    $size = I('get.size', 10, 'intval');
                    $start = I('get.start', 0, 'intval');

                    $list = array();
                    $where = array(
                        'dir' => $mapping [$action]
                    );
                    $m = D('DataFiles');
                    $total = $m->where($where)->field('COUNT(*) as total')->find();
                    $total = intval($total ['total']);
                    if ($total) {
                        foreach ($m->where($where)->limit($start, $size)->order('uptime DESC')->select() as $f) {
                            $list [] = array(
                                'url' => $config [$mapping [$action] . 'ManagerUrlPrefix'] . 'data/' . $f ['dir'] . '/' . $f ['path'],
                                'mtime' => $f ['uptime']
                            );
                        }

                        $sret = array(
                            "state" => "SUCCESS",
                            "list" => $list,
                            "start" => $start,
                            "total" => $total
                        );
                    }

                    $this->ajaxReturn($sret);

                    break;
                case 'catchimage' :
                    set_time_limit(0);
                    $sret = array(
                        'state' => '',
                        'list' => null
                    );
                    $savelist = array();
                    $flist = I('request.' . $config ['catcherFieldName']);
                    if (empty ($flist)) {
                        $sret ['state'] = 'ERROR';
                    } else {
                        $sret ['state'] = 'SUCCESS';
                        foreach ($flist as $f) {
                            if (preg_match('/^(http|ftp|https):\\/\\//i', $f)) {

                                $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                if (in_array('.' . $ext, $config ['catcherAllowFiles'])) {
                                    if ($img = file_get_contents($f)) {
                                        $savepath = save_storage_content('image', $ext, $img);
                                        if ($savepath) {
                                            $savelist [] = array(
                                                'state' => 'SUCCESS',
                                                'url' => 'data/image/' . $savepath,
                                                'size' => strlen($img),
                                                'title' => '',
                                                'original' => '',
                                                'source' => htmlspecialchars($f)
                                            );
                                        } else {
                                            $ret ['state'] = 'Save remote file error!';
                                        }
                                    } else {
                                        $ret ['state'] = 'Get remote file error';
                                    }
                                } else {
                                    $ret ['state'] = 'File ext not allowed';
                                }
                            } else {
                                $savelist [] = array(
                                    'state' => 'not remote image',
                                    'url' => '',
                                    'size' => '',
                                    'title' => '',
                                    'original' => '',
                                    'source' => htmlspecialchars($f)
                                );
                            }
                        }
                        $sret ['list'] = $savelist;
                    }
                    $this->ajaxReturn($sret);

                    break;
                case 'uploadscrawl' :
                    $data = I('post.' . $config ['scrawlFieldName']);
                    if (empty ($data)) {
                        $ret ['state'] = 'Scrawl Data Empty!';
                    } else {
                        $img = base64_decode($data);
                        $savepath = save_storage_content('image', 'png', $img);
                        if ($savepath) {
                            $ret ['state'] = 'SUCCESS';
                            $ret ['url'] = 'data/image/' . $savepath;
                            $ret ['title'] = '';
                            $ret ['original'] = '';
                            $ret ['type'] = 'png';
                            $ret ['size'] = strlen($img);
                        } else {
                            $ret ['state'] = 'Save scrawl file error!';
                        }
                    }
                    break;
                case 'uploadfile' :
                case 'uploadimage' :
                case 'uploadvideo' :
                    $mapping = array(
                        'uploadfile' => 'file',
                        'uploadimage' => 'image',
                        'uploadvideo' => 'video'
                    );

                    $up->maxSize = $config [$mapping [$action] . 'MaxSize'];
                    foreach ($config [$mapping [$action] . 'AllowFiles'] as &$i) {
                        $i = trim($i, '.');
                    }
                    $up->exts = $config [$mapping [$action] . 'AllowFiles'];

                    if (!($info = $up->upload())) {
                        $ret ['state'] = $up->getError();
                    } else {

                        $one = &$info [$config [$mapping [$action] . 'FieldName']];
                        $savefile = upload_tempfile_save_storage($mapping [$action], $up->rootPath . $one ['savepath'] . $one ['savename']);

                        $ret ['state'] = 'SUCCESS';
                        $ret ['url'] = 'data/' . $mapping [$action] . '/' . $savefile;
                        $ret ['title'] = $one ['name'];
                        $ret ['original'] = $one ['name'];
                        $ret ['type'] = $one ['ext'];
                        $ret ['size'] = $one ['size'];
                    }
                    break;

                case 'uploadbutton' :
                    $mapping = array(
                        'image' => 'image',
                        'file' => 'file'
                    );
                    $type = I('get.type');

                    $value_holder = I('post.value_holder');
                    $preview_holder = I('post.preview_holder');
                    $upload_id = I('post.upload_id');
                    $show_alert = I('post.show_alert', 0, 'intval');

                    $up->maxSize = $config [$mapping [$type] . 'MaxSize'];
                    foreach ($config [$mapping [$type] . 'AllowFiles'] as &$i) {
                        $i = trim($i, '.');
                    }
                    $up->exts = $config [$mapping [$type] . 'AllowFiles'];

                    if (!($info = $up->upload())) {
                        $this->show('
<script type="text/javascript">
var win = window.parent.parent ;
win.$.dialog.alert("' . $up->getError() . '");
if(win._T_UPLOAD_BUTTON_WAITING.' . $upload_id . '){
	win._T_UPLOAD_BUTTON_WAITING.' . $upload_id . '.close();
	win._T_UPLOAD_BUTTON_WAITING.' . $upload_id . '=null;
}
</script>');
                    } else {
                        $one = &$info ['value_file'];
                        $savefile = $up->rootPath . $one ['savepath'] . $one ['savename'];
                        $this->show('
<script type="text/javascript">
var win = window.parent.parent ;
win.$("' . $value_holder . '",window.parent.parent.document.body).val("' . $savefile . '");
win.$("' . $preview_holder . '",window.parent.parent.document.body).attr("src","' . __ROOT__ . '/' . $savefile . '");
win.$("' . $preview_holder . '",window.parent.parent.document.body).prop("href","' . __ROOT__ . '/' . $savefile . '");
win.$("' . $preview_holder . '",window.parent.parent.document.body).show();
' . ($show_alert ? 'win.$.dialog.alert("' . L('upload_success') . '!");' : '') . '
if(win._T_UPLOAD_BUTTON_WAITING.' . $upload_id . '){
	win._T_UPLOAD_BUTTON_WAITING.' . $upload_id . '.close();
	win._T_UPLOAD_BUTTON_WAITING.' . $upload_id . '=null;
}
if(win._T_UPLOAD_BUTTON_CALLBACK.' . $upload_id . '){
	win._T_UPLOAD_BUTTON_CALLBACK.' . $upload_id . '("' . $savefile . '");
};
</script>');
                    }

                    return;
                    break;
            }
            $this->ajaxReturn($ret);
        }
    }
}