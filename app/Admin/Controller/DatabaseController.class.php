<?php

namespace Admin\Controller;

use Think\Db;
use Think\Storage;
use Org\Util\String;

class DatabaseController extends AdminController
{
//    static $export_menu = array(
//        'system' => array(
//            '数据库' => array(
//                'backup' => array(
//                    'title' => '数据库备份',
//                    'hiddens' => array()
//                ),
//                'restore' => array(
//                    'title' => '数据库恢复',
//                    'hiddens' => array()
//                ),
//                'operation' => array(
//                    'title' => '数据库操作',
//                    'hiddens' => array()
//                )
//            )
//        )
//    );

    protected function _initialize()
    {
        parent::_initialize();
        load('Common.db');
    }


    public function operation()
    {
        $sql = I('post.sql');
        $db = Db::getInstance();
        $db_prefix = C('DB_PREFIX');
        $no_record = false;
        $data_fields = array();
        $data_records = array();
        $affect_row = 0;
        $is_select = false;
        if (IS_POST) {
            if (preg_match('/^select.*/i', $sql)) {
                $is_select = true;
                $data_records = $db->query($sql);
                if (count($data_records) == 0) {
                    $no_record = true;
                } else {
                    $data_fields = array_keys($data_records [0]);
                }
            } else {
                $affect_row = $db->execute($sql);
            }
        }
        $tables = array();
        foreach (db_get_tables() as $t) {
            $tables [] = "$db_prefix$t";
        }

        $this->affect_row = $affect_row;
        $this->is_select = $is_select;
        $this->data_fields = $data_fields;
        $this->data_records = $data_records;
        $this->no_record = $no_record;
        $this->tables = $tables;
        $this->sql = $sql;
        $this->display();
    }

    public function restore($action = '')
    {
        $db = Db::getInstance();
        $db_prefix = C('DB_PREFIX');

        switch ($action) {
            case 'restore_init' :
                $dir = I('post.dir', '', 'trim');
                if (file_exists($file = 'data/dbbackup/' . $dir . '/')) {
                    $_SESSION ['restore_files'] = array();
                    foreach (list_file($file) as $f) {
                        $_SESSION ['restore_files'] [] = $dir . '/' . $f ['filename'];
                    }
                    $this->success('OK');
                }
                $this->error('ERROR restore dir');
                break;
            case 'restorefile' :
                if (isset ($_SESSION ['restore_files']) && !empty ($_SESSION ['restore_files'])) {
                    $sql_file = array_pop($_SESSION ['restore_files']);
                    if (file_exists($file = 'data/dbbackup/' . $sql_file)) {
                        db_restore_file($file);
                        $this->success($sql_file . ' ' . L('restore_success'));
                    }
                }
                $this->success('OK');
                break;
            case 'deletebackup' :
                $file = I('get.file', '', 'trim');
                if (file_exists($file = 'data/dbbackup/' . $file . '/')) {
                    foreach (list_file($file) as $f) {
                        @unlink($f ['pathname']);
                    }
                    @rmdir($file);
                }
                $this->redirect('Database/restore');
                break;
            default :

                $restore_files = array();
                foreach (list_file('data/dbbackup/') as $f) {
                    if ($f ['isDir']) {
                        if (preg_match('/^\\d{8}_\\d{4}_[A-Z]{10}$/i', $f ['filename'])) {
                            $file_size = 0;
                            $filelist = array();
                            foreach (list_file('data/dbbackup/' . $f ['filename'] . '/') as $ff) {
                                if ($ff ['ext'] == 'sql') {
                                    $file_size += @filesize($ff ['pathname']);
                                    $filelist [] = $ff ['filename'];
                                }
                            }
                            $restore_files [] = array(
                                'name' => $f ['filename'],
                                'size' => $file_size,
                                'filelist' => $filelist
                            );
                        }
                    }
                }
                $this->restore_files = $restore_files;
                $this->display();
        }
    }

    public function backup($action = '')
    {
        $db = Db::getInstance();
        $db_prefix = C('DB_PREFIX');

        switch ($action) {

            case 'backup_init' :
                $this->ajaxReturn(array(
                    'ok' => 1,
                    'dir' => date('Ymd_Hi_') . String::randString(10, 2)
                ));
                break;

            case 'repairtable' :
                $table = I('post.table', '', 'trim');
                if (!db_is_valid_table_name($table)) {
                    $this->error(L('error_table_name') . ' ' . $table);
                }
                switch (C('DB_TYPE')) {
                    case 'mysql' :
                        $db->execute("REPAIR TABLE $db_prefix$table");
                        break;
                }
                $this->success(L('operation_success'));
                break;

            case 'exporttable' :
                $table = I('get.table', '', 'trim');
                if (!db_is_valid_table_name($table)) {
                    $this->error(L('error_table_name') . ' ' . $table);
                }
                force_download_content(date('Ymd') . '_' . $db_prefix . $table . '.sql', db_get_insert_sqls($table));
                break;

            case 'backuptable' :
                $dir = I('post.dir', '', 'trim');
                if (empty ($dir)) {
                    $this->error('ERROR backup_dir_length');
                }
                $table = I('post.table', '', 'trim');
                if (!db_is_valid_table_name($table)) {
                    $this->error(L('error_table_name') . ' ' . $table);
                }

                $sqls = db_get_insert_sqls($table);
                @mkdir('data/dbbackup/' . $dir . '/', 0777, true);
                @file_put_contents('data/dbbackup/' . $dir . '/' . $table . '.sql', $sqls);
                $this->success('OK');
                break;

            default :
                $table_info = array();
                foreach (db_get_tables() as $t) {
                    $infos = $db->query('SELECT count(*) AS total_cnt FROM ' . $db_prefix . $t);
                    $table_info [] = array(
                        'name' => $t,
                        'count' => $infos [0] ['total_cnt']
                    );
                }
                $this->table_info = $table_info;
                $this->display();
        }
    }
}
