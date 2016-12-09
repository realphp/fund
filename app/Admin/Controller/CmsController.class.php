<?php

namespace Admin\Controller;

use Org\Util\String;
use Think\Storage;

abstract class CmsController extends AdminController
{
    // 特殊标记

    // 数据表是否支持添加
    protected $cms_addable = true;

    // 数据表是否支持删除
    protected $cms_deletable = true;

    // 数据是否支持更新
    protected $cms_updatable = true;

    // 额外操作字段（-row-id-表示当前字段）
    protected $cms_record_operation_extra_tpl = '';

    // 数据字段写入处理，如果需要对数据进行特殊处理需要重写此方法
    // 如果数据有问题直接使用$this->error()抛出异常
    // 不需要处理的数据需要直接返回$data
    protected function field_process_write($field, $data, &$data_all = null)
    {
        return $data;
    }
    // 数据字段读取处理，如果需要对数据进行特殊处理需要重写此方法
    // 如果数据有问题直接使用$this->error()抛出异常
    // 不需要处理的数据需要直接返回$data
    // 通常这个函数会使用 serialize 等序列化函数来进行处理
    protected function field_process_read($field, $data, &$data_all = null)
    {
        return $data;
    }
    // 数据字段显示处理，如果需要对数据进行特殊处理需要重写此方法
    // 不需要处理的数据需要直接返回$data
    protected function field_process_view($field, $data, &$data_all = null)
    {
        return $data;
    }
    // 删除指定ID记录前的操作，如果需要对数据进行特殊处理需要重写此方法
    // 如果数据有问题直接使用$this->error()抛出异常
    protected function record_preprocess_delete($pk_id)
    {
    }

    // 删除指定ID记录后的操作，例如需要更新缓存等
    protected function record_postprocess_delete($pk_id)
    {
    }

    // 修改指定ID记录后的操作，例如需要更新缓存等
    protected function record_postprocess_update($pk_id)
    {
    }

    // 新增加记录前的操作，例如更改数据等
    protected function record_preprocess_insert(&$data_all = null)
    {
    }

    // 新增加记录后的操作，例如更新缓存等
    protected function record_postprocess_insert($pk_id)
    {
    }

    // 如果不需要build方法，只需要覆盖 build方法，然后在继承类中调用 parent::build_empty()
    protected function build_empty($yummy = false)
    {
        if (!$yummy) {
            $this->success(L('build_success'));
        }
    }

    /**
     * 判断一个表是否存在于数据库
     *
     * @param string $table
     */
    protected function build_table_exists($table)
    {
        static $tables = null;
        static $db_prefix = null;

        if (null === $tables) {
            $db = \Think\Db::getInstance();
            $db_prefix = C('DB_PREFIX');
            $tables = $db->getTables();
        }

        if (in_array($db_prefix . $table, $tables)) {
            return true;
        }
        return false;
    }

    // 如果不需要build方法，只需要覆盖 build方法，然后在继承类中调用 parent::build_empty()
    public function build($yummy = false)
    {
        $db = \Think\Db::getInstance();
        $db_prefix = C('DB_PREFIX');

        if (empty ($this->cms_pk)) {
            $err = 'Empty cms_pk in ' . CONTROLLER_NAME;
            if ($yummy) {
                return $err;
            } else {
                $this->error($err);
            }
        }
        if (empty ($this->cms_table)) {
            $err = 'Empty cms_table in ' . CONTROLLER_NAME;
            if ($yummy) {
                return $err;
            } else {
                $this->error($err);
            }
        }

        switch (C('DB_TYPE')) {
            case 'mysql' :

                if (!$this->build_table_exists($this->cms_table)) {
                    $db->execute("DROP TABLE IF EXISTS `$db_prefix$this->cms_table`");

                    $sql = ("CREATE TABLE `$db_prefix$this->cms_table` (
`$this->cms_pk` INT UNSIGNED NOT NULL AUTO_INCREMENT,
%FIELDS_SQL%
%PRIMARY_KEY_SQL%
%UNIQUE_KEY_SQL%
%KEY_SQL%
) ENGINE=$this->cms_db_engine AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

                    $sql_fields = array();
                    $sql_primary_key = "PRIMARY KEY (`$this->cms_pk`)";
                    $sql_unique_key = array();
                    $sql_key = array();

                    foreach ($this->cms_fields as $f => $fi) {
                        $rules = explode('|', $fi ['rules']);
                        switch ($fi ['type']) {
                            case 'baidu_map':
                                $defaults = explode(',', $fi['default']);
                                $sql_fields [] = "`${f}_lng` DOUBLE NOT NULL DEFAULT '$defaults[0]' COMMENT '$fi[title]'";
                                $sql_fields [] = "`${f}_lat` DOUBLE NOT NULL DEFAULT '$defaults[1]' COMMENT '$fi[title]'";
                                break;
                            case 'tag':
                            case 'text' :
                            case 'imagefile' :
                            case 'commonfile' :
                            case 'selecttext' :
                            case 'checkbox' :
                                if (empty ($fi ['length'])) {
                                    $fi ['length'] = 200;
                                }
                                $ftype = 'VARCHAR';
                                if (in_array('lengthfixed', $rules)) {
                                    $ftype = 'CHAR';
                                }
                                $fnull = '';
                                if (in_array('required', $rules)) {
                                    $fnull = 'NOT NULL';
                                }
                                $sql_fields [] = "`$f` $ftype($fi[length]) $fnull DEFAULT '$fi[default]' COMMENT '$fi[title]'";
                                break;
                            case 'number' :
                            case 'datetime' :
                            case 'date' :
                            case 'selectnumber' :
                            case 'treeparent':
                            case 'member_uid':
                            case 'cms_id':
                            case 'china_district':
                                $funsigned = '';
                                if (in_array($fi ['type'], array(
                                        'date',
                                        'datetime',
                                        'member_uid'
                                    )) || in_array('unsigned', $rules)
                                ) {
                                    $funsigned = 'UNSIGNED';
                                }
                                $fnull = '';
                                if (in_array('required', $rules)) {
                                    $fnull = 'NOT NULL';
                                }
                                $sql_fields [] = "`$f` INT $funsigned $fnull DEFAULT '$fi[default]' COMMENT '$fi[title]'";
                                break;
                            case 'richtext' :
                            case 'bigtext' :
                                $sql_fields [] = "`$f` TEXT COMMENT '$fi[title]'";
                                break;
                            case 'switch' :
                                $sql_fields [] = "`$f` TINYINT UNSIGNED NOT NULL DEFAULT '$fi[default]' COMMENT '$fi[title]'";
                                break;
                            default :
                                $err = 'Unknown field ' . $fi ['type'];
                                if ($yummy) {
                                    return $err;
                                } else {
                                    $this->error($err);
                                }
                        }
                        if (in_array($fi ['type'], array(
                            'switch',
                            'text',
                            'number',
                            'datetime',
                            'date',
                            'selecttext',
                            'selectnumber',
                            'checkbox',
                            'treeparent',
                            'member_uid',
                            'cms_id'
                        ))) {
                            if (in_array('unique', $rules)) {
                                $sql_unique_key [] = "UNIQUE KEY `$f` (`$f`)";
                            } else if (in_array('searchable', $rules)) {
                                $sql_key [] = "KEY `$f` (`$f`)";
                            }
                        }
                    }

                    $sql = str_replace(array(
                        '%FIELDS_SQL%',
                        '%PRIMARY_KEY_SQL%',
                        '%UNIQUE_KEY_SQL%',
                        '%KEY_SQL%'
                    ), array(
                        join(",\n", $sql_fields) . ((empty ($sql_primary_key) && empty ($sql_unique_key) && empty ($sql_key)) ? '' : ",\n"),
                        $sql_primary_key . ((empty ($sql_primary_key) || (empty ($sql_unique_key) && empty ($sql_key))) ? '' : ",\n"),
                        join(",\n", $sql_unique_key) . ((empty ($sql_unique_key) || empty ($sql_key)) ? '' : ",\n"),
                        join(",\n", $sql_key)
                    ), $sql);

                    $db->execute($sql);
                }
                break;
            default :
                $err = 'Unkown DB_TYPE ' . C('DB_TYPE');
                if ($yummy) {
                    return $err;
                } else {
                    $this->error($err);
                }
        }
        if (!$yummy) {
            $this->success(L('build_success'));
        }
    }

    // 数据列表
    public function cmslist()
    {
        if (IS_POST) {

            $current = I('post.current', 1, 'intval');
            $rowCount = I('post.rowCount', 10, 'intval');
            $sort = I('post.sort', array());
            $searchPhrase = I('post.searchPhrase');

            $m = M($this->cms_table);

            // pre process
            $where = array();
            if ($searchPhrase && !empty ($this->cms_fields_search)) {
                foreach ($this->cms_fields_search as $k) {
                    $where [$k] = array(
                        'LIKE',
                        "%$searchPhrase%"
                    );
                }
                if (count($where) > 1) {
                    $where ['_logic'] = 'OR';
                }
            }
            $order = null;
            foreach ($sort as $f => $d) {
                $order = "$f $d";
            }
            if (empty ($order)) {
                $order = $this->cms_pk . ' DESC';
            }

            // get info
            $total = $m->where($where)->count();
            if ($order) {
                $m->order($order);
            }

            // 字段预处理
            $_cms_fields = &$this->cms_fields;
            foreach ($this->cms_fields_list as $k => &$v) {
                if (isset($_cms_fields[$v])) {
                    switch ($_cms_fields[$v]['type']) {
                        case 'baidu_map':
                            unset($this->cms_fields_list[$k]);
                            $this->cms_fields_list[] = $v . '_lng';
                            $this->cms_fields_list[] = $v . '_lat';
                            break;
                    }
                }
            }

            $data = array();
            $datas = $m->field($this->cms_fields_list)->where($where)->page($current, $rowCount)->select();
            if (!empty ($datas)) {
                foreach ($datas as &$v) {
                    $item = array();
                    foreach ($v as $kk => $vv) {
                        if ($kk == $this->cms_pk) {
                            $item [$kk] = $vv;
                            continue;
                        }
                        if (!isset($this->cms_fields [$kk])) {
                            $kk = substr($kk, 0, strrpos($kk, '_'));
                        }
                        switch ($this->cms_fields [$kk] ['type']) {
                            case 'tag':
                                $item[$kk] = htmlspecialchars(join(',', cms_tag_ids2names($this->cms_fields[$kk]['data'], $vv)));
                                break;
                            case 'text' :
                            case 'number' :
                                $item [$kk] = htmlspecialchars($vv);
                                break;
                            case 'datetime' :
                                $item [$kk] = date('Y-m-d H:i:s', $vv);
                                break;
                            case 'date' :
                                $item [$kk] = date('Y-m-d', $vv);
                                break;
                            case 'imagefile' :
                                if ($vv) {
                                    $item [$kk] = '<a href="#" onclick="$.dialog({content:\'url:' . $vv . '\'});return false;">' . L('view') . '</a>';
                                } else {
                                    $item [$kk] = '[' . L('none') . ']';
                                }
                                break;
                            case 'commonfile' :
                                if ($vv) {
                                    $item [$kk] = '<a href="' . $vv . '" target="_blank">' . L('view') . '</a>';
                                } else {
                                    $item [$kk] = '[' . L('none') . ']';
                                }
                                break;
                            case 'switch' :
                                if ($vv) {
                                    $item [$kk] = L('switch_on');
                                } else {
                                    $item [$kk] = L('switch_off');
                                }
                                break;
                            case 'bigtext' :
                            case 'richtext' :
                                $item [$kk] = htmlspecialchars(String::msubstr(remove_html($vv), 0, 20));
                                break;
                            case 'selecttext' :
                            case 'selectnumber' :
                            case 'checkbox' :
                                $item [$kk] = cms_field_option_get_titles($this->cms_fields [$kk] ['data'], explode(',', $vv));
                                $item [$kk] = htmlspecialchars(join(',', $item [$kk]));
                                break;
                            case 'treeparent':
                                if (0 == $vv) {
                                    $item[$kk] = '[' . L('super_category') . ']';
                                } else {
                                    $one = $m->field($this->cms_fields[$kk]['name'])->where(array($this->cms_pk => $vv))->find();
                                    if (empty($one)) {
                                        $item[$kk] = '[' . L('none') . ']';
                                    } else {
                                        $item[$kk] = htmlspecialchars($one[$this->cms_fields[$kk]['name']]);
                                    }
                                }
                                break;
                            case 'member_uid':
                                if (0 == $vv || !has_module('Member')) {
                                    $item[$kk] = '[' . L('none') . ']';
                                } else {
                                    $one = D('MemberUser')->field('username,cellphone,email')->where(array('uid' => $vv))->find();
                                    if (empty($one)) {
                                        $item[$kk] = '[' . L('none') . ']';
                                    } else {
                                        foreach ($one as &$onev) {
                                            if ($onev) {
                                                if (access_permit('userview', 'ModMember')) {
                                                    $item[$kk] = '<a href="#" class="command-dialog-page" data-href="' . U('ModMember/userview?id=' . $vv) . '">' . htmlspecialchars($onev) . '</a>';
                                                } else {
                                                    $item[$kk] = htmlspecialchars($onev);
                                                }
                                                break;
                                            }
                                        }
                                        if (empty($item[$kk])) {
                                            $item[$kk] = '[' . L('none') . ']';
                                        }
                                    }
                                }
                                break;
                            case 'cms_id':
                                if (0 == $vv) {
                                    $item[$kk] = '[' . L('none') . ']';
                                } else {
                                    $s = explode('|', $this->cms_fields [$kk]['data']);
                                    $one = D($s[0])->field($s[2])->where(array($s[1] => $vv))->find();
                                    if (empty($one)) {
                                        $item[$kk] = '[' . L('none') . ']';
                                    } else {
                                        $item[$kk] = htmlspecialchars($one[$s[2]]);
                                    }
                                }
                                break;
                            case 'china_district':
                                $tree = D('ChinaDistrict', 'Service')->get_inherent($vv);
                                if (empty($tree)) {
                                    $item[$kk] = '[' . L('none') . ']';
                                } else {
                                    $item[$kk] = array();
                                    foreach ($tree as &$tree_) {
                                        $item[$kk][] = $tree_['name'];
                                    }
                                    $item[$kk] = join(' &gt; ', $item[$kk]);
                                }
                                break;
                            case 'baidu_map':
                                $item[$kk] = '( ' . $v[$kk . '_lng'] . ', ' . $v[$kk . '_lat'] . ' )';
                                break;
                        }
                        $item [$kk] = $this->field_process_view($kk, $item [$kk], $v);
                    }
                    $data [] = $item;
                }
            }
            $json = array(
                'current' => $current,
                'rowCount' => $total > $rowCount ? $rowCount : $total,
                'total' => $total,
                'rows' => $data
            );
            $this->ajaxReturn($json);
        }

        $fields = array();
        foreach ($this->cms_fields_list as &$v) {
            if (isset ($this->cms_fields [$v])) {
                $fields [$v] = $this->cms_fields [$v];
            } else {
                $fields [$v] = '';
            }
        }

        $this->cfg_addable = ($this->cms_addable && !$this->attr_all_field_readonly());
        $this->cfg_deletable = $this->cms_deletable;
        $this->cfg_updatable = $this->cms_updatable;
        $this->cfg_all_field_readonly = $this->attr_all_field_readonly();
        $this->cfg_record_operation_extra_tpl = $this->cms_record_operation_extra_tpl;


        $this->assign('fields', $fields);

        $this->display('Cms:cmslist');
    }

    protected function attr_all_field_readonly()
    {
        foreach ($this->cms_fields as &$v) {
            if (strpos($v ['rules'], 'readonly') === false) {
                return false;
            }
        }
        return true;
    }

    // 增删查改处理
    public function cmshandle($action = '', $id = 0, $page = 0)
    {

        $this->cfg_addable = ($this->cms_addable && !$this->attr_all_field_readonly());
        $this->cfg_deletable = $this->cms_deletable;
        $this->cfg_updatable = $this->cms_updatable;
        $this->cfg_all_field_readonly = $this->attr_all_field_readonly();

        $id = intval($id);
        $page = intval($page);
        switch ($action) {

            case 'delete' :
                // //////////////////////////////////////////////// DELETE
                if (!$this->cms_deletable) {
                    $this->error('Delete forbidden');
                }
                $ids = array();
                foreach (explode(',', I('post.ids', '', 'trim')) as $id) {
                    $id = intval($id);
                    if ($id) {
                        $ids [] = $id;
                    }
                }
                if (!empty ($ids)) {

                    // 如果有treeparent需要预检查
                    $treeparent_field = null;
                    foreach ($this->cms_fields as $k => &$f) {
                        switch ($f ['type']) {
                            case 'treeparent' :
                                $treeparent_field = $k;
                                break;
                        }
                    }
                    if ($treeparent_field) {
                        foreach ($ids as $id) {
                            if (!cms_treeparent_deleteable($this->cms_table, $this->cms_pk, $treeparent_field, $id)) {
                                $this->error('节点(ID:' . $id . ')有子节点，不能删除');
                            }
                        }
                    }


                    // 预删除
                    foreach ($ids as $id) {
                        $this->record_preprocess_delete($id);
                    }

                    // delete data files
                    $res_fields = array();
                    foreach ($this->cms_fields as $k => &$f) {
                        switch ($f ['type']) {
                            case 'imagefile' :
                            case 'commonfile' :
                                $res_fields [] = $k;
                                break;
                        }
                    }

                    $m = D($this->cms_table);
                    foreach ($m->field($res_fields)->where(array(
                        $this->cms_pk => array(
                            'IN',
                            $ids
                        )
                    ))->select() as $r) {
                        foreach ($res_fields as $f) {
                            safe_delete_storage_file($r [$f]);
                        }
                    }

                    $m->delete(join(',', $ids));
                    foreach ($ids as $id) {
                        $this->record_postprocess_delete($id);
                    }
                }

                $this->success('OK');
                break;

            case 'add' :
                // //////////////////////////////////////////////// ADD
                if (!$this->cms_addable) {
                    $this->error('Add forbidden');
                }

                if (empty ($this->cms_fields_add)) {
                    $this->cms_fields_add = array_keys($this->cms_fields);
                }

                foreach ($this->cms_fields as $k => $f) {
                    $rules = explode('|', $f ['rules']);
                    if (in_array('required', $rules) && !in_array($k, $this->cms_fields_add)) {
                        $this->cms_fields_add [] = $k;
                    }
                    if (in_array('readonly', $rules) && in_array($k, $this->cms_fields_add)) {
                        $keys = array_keys($this->cms_fields_add, $k);
                        unset($this->cms_fields_add[$keys[0]]);
                    }
                }

                if (IS_POST) {
                    $model = D($this->cms_table);

                    $postdata = array();
                    foreach ($this->cms_fields_add as $k) {
                        $f = $this->cms_fields [$k];
                        switch ($f ['type']) {
                            case 'baidu_map':
                                $postdata [$k . '_lng'] = I("post.${k}_lng", 0, 'floatval');
                                $postdata [$k . '_lat'] = I("post.${k}_lat", 0, 'floatval');
                                break;
                            case 'china_district':
                                $postdata [$k] = I("post.$k", 0, 'intval');
                                if (!has_module('ChinaDistrict')) {
                                    $this->error('Mod Member not install');
                                }
                                if (!D('ChinaDistrict')->where(array('id' => $postdata[$k]))->find()) {
                                    $this->error('Area id=' . $postdata[$k] . ' not exists');
                                }
                                break;
                            case 'cms_id':
                                $postdata [$k] = I("post.$k", 0, 'intval');
                                $s = explode('|', $f['data']);
                                if (!D($s[0])->where(array($s[1] => $postdata[$k]))->find()) {
                                    $this->error($s[0] . ' ' . $s[1] . '=' . $postdata[$k] . ' not exists');
                                }
                                break;
                            case 'member_uid' :
                                $postdata [$k] = I("post.$k", 0, 'intval');
                                if (!has_module('Member')) {
                                    $this->error('Mod Member not install');
                                }
                                if (!D('MemberUser')->where(array('uid' => $postdata[$k]))->find()) {
                                    $this->error('Member uid=' . $postdata[$k] . ' not exists');
                                }
                                break;
                            case 'tag':
                                $postdata[$k] = explode(',', I("post.$k", '', 'trim'));
                                break;
                            case 'text' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                break;
                            case 'number' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                if ('' != $postdata [$k]) {
                                    $postdata [$k] = intval($postdata [$k]);
                                }
                                break;
                            case 'switch' :
                                $postdata [$k] = I("post.$k", 0, 'intval');
                                break;
                            case 'bigtext' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                break;
                            case 'datetime' :
                            case 'date' :
                                $postdata [$k] = I("post.$k", '', 'strtotime');
                                break;
                            case 'selectnumber' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                if ('' != $postdata [$k]) {
                                    $postdata [$k] = intval($postdata [$k]);
                                }
                                if (!cms_field_option_valid($f ['data'], $postdata [$k])) {
                                    $this->error($f ['title'] . ' ' . L('invalid'));
                                }
                                break;
                            case 'selecttext' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                if (!cms_field_option_valid($f ['data'], $postdata [$k])) {
                                    $this->error($f ['title'] . ' ' . L('invalid'));
                                }
                                break;
                            case 'checkbox' :
                                $postdata [$k] = I("post.$k", array());
                                if (!cms_field_option_valid($f ['data'], $postdata [$k])) {
                                    $this->error($f ['title'] . ' ' . L('invalid'));
                                }
                                $postdata [$k] = join(',', $postdata [$k]);
                                break;
                            case 'richtext' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                // TODO XSS Filter
                                break;
                            case 'imagefile' :
                            case 'commonfile' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                if (!is_upload_temp_file($postdata [$k])) {
                                    $postdata [$k] = '';
                                }

                                if ($postdata [$k]) {
                                    $ext = strtolower(pathinfo($postdata [$k], PATHINFO_EXTENSION));
                                    if (!in_array($ext, $f ['extension'])) {
                                        $this->error($f ['title'] . ' ' . L('extention_invalid') . ' ' . $ext);
                                    }
                                }
                                break;

                            case 'treeparent':
                                $postdata [$k] = I("post.$k", 0, 'trim');
                                if (!cms_treeparent_option_valid($this->cms_table, $this->cms_pk, $postdata[$k])) {
                                    $this->error($f ['title'] . ' ' . L('invalid'));
                                }
                                break;

                            default :
                                $this->error('Unknown field ' . $f ['title'] . ':' . $f ['type']);
                                break;
                        }
                        $postdata [$k] = $this->field_process_write($k, $postdata [$k], $postdata);
                        $rules = explode('|', $f ['rules']);
                        if (in_array('required', $rules)) {
                            switch ($this->cms_fields[$k]['type']) {
                                case 'baidu_map':
                                    if (!isset ($postdata [$k . '_lng']) || '' === $postdata [$k . '_lng']) {
                                        $this->error($f ['title'] . ' ' . L('empty'));
                                    }
                                    if (!isset ($postdata [$k . '_lat']) || '' === $postdata [$k . '_lat']) {
                                        $this->error($f ['title'] . ' ' . L('empty'));
                                    }
                                    break;
                                default:
                                    if (!isset ($postdata [$k]) || '' === $postdata [$k]) {
                                        $this->error($f ['title'] . ' ' . L('empty'));
                                    }
                                    break;
                            }
                        }
                        if (in_array('readonly', $rules)) {
                            switch ($this->cms_fields[$k]['type']) {
                                case 'baidu_map':
                                    if (isset ($postdata [$k . '_lng'])) {
                                        unset ($postdata [$k . '_lng']);
                                    }
                                    if (isset ($postdata [$k . '_lat'])) {
                                        unset ($postdata [$k . '_lat']);
                                    }
                                    break;
                                default:
                                    if (isset ($postdata [$k])) {
                                        unset ($postdata [$k]);
                                    }
                                    break;
                            }
                        }
                        if (in_array('unique', $rules)) {
                            if ($model->where(array(
                                $k => $postdata [$k]
                            ))->find()
                            ) {
                                $this->error($f ['title'] . ' ' . L('unique'));
                            }
                        }
                    }

                    // 很可能会出错的地方（文件操作）
                    foreach ($this->cms_fields_add as $k) {
                        $f = $this->cms_fields [$k];
                        switch ($f ['type']) {
                            case 'imagefile' :
                            case 'commonfile' :
                                $dir = 'empty';
                                switch ($f ['type']) {
                                    case 'imagefile' :
                                        $dir = 'image';
                                        break;
                                    case 'commonfile' :
                                        $dir = 'file';
                                        break;
                                }
                                $postdata [$k] = 'data/' . $dir . '/' . upload_tempfile_save_storage($dir, $postdata [$k]);
                        }
                    }

                    // 不会出错的地方
                    foreach ($this->cms_fields_add as $k) {
                        $f = $this->cms_fields [$k];
                        switch ($f ['type']) {
                            case 'tag' :
                                $postdata[$k] = cms_tag_names2ids($f['data'], $postdata[$k]);
                                S('tag_pool/name_id/' . $f['data'], null);
                                S('tag_pool/id_name/' . $f['data'], null);
                                break;
                        }
                    }

                    $this->record_preprocess_insert($postdata);
                    if ($model->create($postdata) && ($insert_pk_id = $model->add()) > 0) {
                        $this->record_postprocess_insert($insert_pk_id);
                        $this->success('', U(CONTROLLER_NAME . '/cmslist#' . $page));
                    } else {
                        $this->error($model->getError());
                    }
                } // IS_POST

                $addon_css = array();
                $addon_js = array();
                $addon_hjs = array();
                $fields = array();
                foreach ($this->cms_fields_add as $k) {
                    $fields [$k] = $this->cms_fields [$k];
                    $fields [$k] ['rules'] = explode('|', $fields [$k] ['rules']);
                    if (!isset ($fields [$k] ['default'])) {
                        $fields [$k] ['default'] = '';
                    }
                    switch ($fields [$k] ['type']) {
                        case 'baidu_map':
                            $fields [$k] ['default'] = explode(',', $fields [$k] ['default']);
                            $fields [$k] ['value']['lng'] = $fields [$k] ['default'][0];
                            $fields [$k] ['value']['lat'] = $fields [$k] ['default'][1];
                            break;
                        case 'tag':
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            $fields[$k]['option'] = cms_tag_option_get($fields[$k]['data']);
                            break;
                        case 'text' :
                        case 'number' :
                        case 'switch' :
                        case 'bigtext' :
                        case 'member_uid':
                        case 'cms_id':
                        case 'china_district':
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            break;
                        case 'datetime' :
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            if (empty ($fields [$k] ['value'])) {
                                $fields [$k] ['value'] = time();
                            }
                            break;
                        case 'date' :
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            if (empty ($fields [$k] ['value'])) {
                                $fields [$k] ['value'] = time();
                            }
                            break;
                        case 'selectnumber' :
                        case 'selecttext' :
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            $fields [$k] ['option'] = cms_field_option_conv($fields [$k] ['data']);
                            break;
                        case 'treeparent':
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            $list = cms_treeparent_list($this->cms_table, $this->cms_pk, $fields[$k]['name'], $k, $fields[$k]['sort']);
                            $fields [$k] ['option'] = cms_treeparent_option($list, $this->cms_pk, $fields[$k]['name']);
                            break;
                        case 'checkbox' :
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            $fields [$k] ['option'] = cms_field_option_conv($fields [$k] ['data']);
                            break;
                        case 'richtext' :
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            break;
                        case 'imagefile' :
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            if (!file_exists($fields [$k] ['value'])) {
                                $fields [$k] ['value'] = __ROOT__ . '/asserts/image/none.png';
                            }
                            break;
                        case 'commonfile' :
                            //$addon_js [__ROOT__ . '/asserts/upload_button/upload_button' . C('TMPL_PARSE_STRING.__JS_SUFFIX__')] = true;
                            $fields [$k] ['value'] = $fields [$k] ['default'];
                            break;

                        default :
                            $this->error('Unknown field ' . $fields [$k] ['type']);
                            break;
                    }
                }

                $datas = array();
                foreach ($fields as $k => $v) {
                    if (isset($fields[$k]['value'])) {
                        $datas[$k] = &$fields[$k]['value'];
                    }
                }

                foreach ($datas as $k => $v) {
                    $datas [$k] = $this->field_process_read($k, $datas[$k], $datas);
                }


                $this->addon_css = $addon_css;
                $this->addon_js = $addon_js;
                $this->addon_hjs = $addon_hjs;

                $this->fields = $fields;
                $this->page = $page;

                $this->display('Cms:add_edit');
                break;

            case 'edit' :
                // //////////////////////////////////////////////// EDIT

                if (empty ($this->cms_fields_edit)) {
                    $this->cms_fields_edit = array_keys($this->cms_fields);
                }
                $model = D($this->cms_table);
                $model_data = $model->find($id);
                if (!$model_data) {
                    $this->error('ERROR ID ' . $id);
                }

                if (IS_POST) {

                    if (!$this->cms_updatable) {
                        $this->error('Update forbidden');
                    }

                    $postdata = array();
                    foreach ($this->cms_fields_edit as $k) {
                        $f = $this->cms_fields [$k];
                        switch ($f ['type']) {
                            case 'baidu_map':
                                $postdata [$k . '_lng'] = I("post.${k}_lng", 0, 'floatval');
                                $postdata [$k . '_lat'] = I("post.${k}_lat", 0, 'floatval');
                                break;
                            case 'china_district':
                                $postdata [$k] = I("post.$k", 0, 'intval');
                                if (!has_module('ChinaDistrict')) {
                                    $this->error('Mod Member not install');
                                }
                                if (!D('ChinaDistrict')->where(array('id' => $postdata[$k]))->find()) {
                                    $this->error('Area id=' . $postdata[$k] . ' not exists');
                                }
                                break;
                            case 'cms_id':
                                $postdata [$k] = I("post.$k", 0, 'intval');
                                $s = explode('|', $f['data']);
                                if (!D($s[0])->where(array($s[1] => $postdata[$k]))->find()) {
                                    $this->error($s[0] . ' ' . $s[1] . '=' . $postdata[$k] . ' not exists');
                                }
                                break;
                            case 'member_uid':
                                $postdata [$k] = I("post.$k", 0, 'intval');
                                if (!has_module('Member')) {
                                    $this->error('Mod Member not install');
                                }
                                if (!D('MemberUser')->where(array('uid' => $postdata[$k]))->find()) {
                                    $this->error('UID ' . $postdata[$k] . ' not exists');
                                }
                                break;
                            case 'tag':
                                $postdata[$k] = explode(',', I("post.$k", '', 'trim'));
                                break;
                            case 'text' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                break;
                            case 'number' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                if ('' != $postdata [$k]) {
                                    $postdata [$k] = intval($postdata [$k]);
                                }
                                break;
                            case 'switch' :
                                $postdata [$k] = I("post.$k", 0, 'intval');
                                break;
                            case 'bigtext' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                break;
                            case 'datetime' :
                            case 'date' :
                                $postdata [$k] = I("post.$k", '', 'strtotime');
                                break;
                            case 'selectnumber' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                if ('' != $postdata [$k]) {
                                    $postdata [$k] = intval($postdata [$k]);
                                }
                                if (!cms_field_option_valid($f ['data'], $postdata [$k])) {
                                    $this->error($f ['title'] . ' ' . L('invalid'));
                                }
                                break;
                            case 'selecttext' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                if (!cms_field_option_valid($f ['data'], $postdata [$k])) {
                                    $this->error($f ['title'] . ' ' . L('invalid'));
                                }
                                break;
                            case 'checkbox' :
                                $postdata [$k] = I("post.$k", array());
                                if (!cms_field_option_valid($f ['data'], $postdata [$k])) {
                                    $this->error($f ['title'] . ' ' . L('invalid'));
                                }
                                $postdata [$k] = join(',', $postdata [$k]);
                                break;
                            case 'richtext' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                // TODO XSS Filter
                                break;
                            case 'imagefile' :
                            case 'commonfile' :
                                $postdata [$k] = I("post.$k", '', 'trim');
                                $reg = upload_temp_dir_get();
                                if (preg_match('/^' . preg_quote($reg, '/') . '/', $postdata [$k])) {
                                    if ($postdata [$k]) {
                                        $ext = strtolower(pathinfo($postdata [$k], PATHINFO_EXTENSION));
                                        if (!in_array($ext, $f ['extension'])) {
                                            $this->error($f ['title'] . ' ' . L('extention_invalid') . ' ' . $ext);
                                        }
                                    }
                                }
                                break;
                            case 'treeparent':
                                $postdata [$k] = I("post.$k", 0, 'trim');
                                if (!cms_treeparent_option_valid($this->cms_table, $this->cms_pk, $postdata[$k])) {
                                    $this->error($f ['title'] . ' ' . L('invalid'));
                                }
                                // 检查是否可以修改
                                // 当当前节点是父节点与子节点唯一的连接时，不能断开
                                if (!cms_treeparent_changeable($this->cms_table, $this->cms_pk, $k, $model_data[$this->cms_pk], $postdata[$k])) {
                                    $this->error($f['title'] . ' 不能修改父节点为该节点');
                                }
                                break;

                            default :
                                $this->error('Unknown field ' . $f ['title'] . ':' . $f ['type']);
                                break;
                        }
                        $postdata [$k] = $this->field_process_write($k, $postdata [$k], $postdata);
                        $rules = explode('|', $f ['rules']);
                        if (in_array('required', $rules)) {
                            switch ($this->cms_fields[$k]['type']) {
                                case 'baidu_map':
                                    if (!isset ($postdata [$k . '_lng']) || '' === $postdata [$k . '_lng']) {
                                        $this->error($f ['title'] . ' ' . L('empty'));
                                    }
                                    if (!isset ($postdata [$k . '_lat']) || '' === $postdata [$k . '_lat']) {
                                        $this->error($f ['title'] . ' ' . L('empty'));
                                    }
                                    break;
                                default:
                                    if (!isset ($postdata [$k]) || '' === $postdata [$k]) {
                                        $this->error($f ['title'] . ' ' . L('empty'));
                                    }
                                    break;
                            }
                        }
                        if (in_array('readonly', $rules)) {
                            switch ($this->cms_fields[$k]['type']) {
                                case 'baidu_map':
                                    if (isset ($postdata [$k . '_lng'])) {
                                        unset ($postdata [$k . '_lng']);
                                    }
                                    if (isset ($postdata [$k . '_lat'])) {
                                        unset ($postdata [$k . '_lat']);
                                    }
                                    break;
                                default:
                                    if (isset ($postdata [$k])) {
                                        unset ($postdata [$k]);
                                    }
                                    break;
                            }
                        }
                        if (in_array('unique', $rules)) {
                            $one = $model->where(array(
                                $k => $postdata [$k]
                            ))->find();
                            if ($one && $one [$this->cms_pk] != $model_data [$this->cms_pk]) {
                                $this->error($f ['title'] . ' ' . L('unique'));
                            }
                        }
                    }

                    // 很可能会出错的地方
                    foreach ($this->cms_fields_edit as $k) {
                        $f = $this->cms_fields [$k];
                        switch ($f ['type']) {
                            case 'imagefile' :
                            case 'commonfile' :
                                if ($postdata [$k] != $model_data [$k]) {
                                    if (is_upload_temp_file($postdata [$k])) {

                                        $dir = 'empty';
                                        switch ($f ['type']) {
                                            case 'imagefile' :
                                                $dir = 'image';
                                                break;
                                            case 'commonfile' :
                                                $dir = 'file';
                                                break;
                                        }

                                        $postdata [$k] = 'data/' . $dir . '/' . upload_tempfile_save_storage($dir, $postdata [$k]);
                                    }
                                    safe_delete_storage_file($model_data [$k]);
                                }
                        }
                    }

                    // 不会出错的地方
                    foreach ($this->cms_fields_edit as $k) {
                        $f = $this->cms_fields [$k];
                        switch ($f ['type']) {
                            case 'tag' :
                                $postdata[$k] = cms_tag_names2ids($f['data'], $postdata[$k]);
                                S('tag_pool/name_id/' . $f['data'], null);
                                S('tag_pool/id_name/' . $f['data'], null);
                                break;
                        }
                    }

                    $postdata [$this->cms_pk] = $model_data [$this->cms_pk];
                    if ($model->create($postdata)) {
                        $model->save();
                        $this->record_postprocess_update($postdata [$this->cms_pk]);
                        $this->success('', U(CONTROLLER_NAME . '/cmslist#' . $page));
                    } else {
                        $this->error($model->getError());
                    }
                } // IS_POST

                $addon_css = array();
                $addon_js = array();
                $addon_hjs = array();
                $fields = array();
                foreach ($this->cms_fields_edit as $k) {
                    $fields [$k] = $this->cms_fields [$k];
                    $fields [$k] ['rules'] = explode('|', $fields [$k] ['rules']);
                    if (!$this->cms_updatable) {
                        if (!in_array('readonly', $fields[$k]['rules'])) {
                            $fields[$k]['rules'][] = 'readonly';
                        }
                    }
                    $model_data [$k] = $this->field_process_read($k, $model_data [$k], $model_data);
                    switch ($fields [$k] ['type']) {
                        case 'baidu_map':
                            $fields [$k] ['default'] = explode(',', $fields [$k] ['default']);
                            $fields [$k] ['value']['lng'] = $model_data [$k . '_lng'];
                            $fields [$k] ['value']['lat'] = $model_data [$k . '_lat'];
                            break;
                        case 'tag':
                            $fields [$k] ['value'] = cms_tag_ids2names($fields [$k]['data'], $model_data [$k]);
                            $fields[$k]['option'] = cms_tag_option_get($fields[$k]['data']);
                            break;
                        case 'text' :
                        case 'number' :
                        case 'switch' :
                        case 'date' :
                        case 'bigtext' :
                        case 'member_uid':
                        case 'cms_id':
                        case 'china_district':
                            $fields [$k] ['value'] = $model_data [$k];
                            break;
                        case 'datetime' :
                            $fields [$k] ['value'] = $model_data [$k];
                            break;
                        case 'selectnumber' :
                        case 'selecttext' :
                            $fields [$k] ['value'] = $model_data [$k];
                            $fields [$k] ['option'] = cms_field_option_conv($fields [$k] ['data']);
                            break;
                        case 'checkbox' :
                            $fields [$k] ['value'] = explode(',', $model_data [$k]);
                            $fields [$k] ['option'] = cms_field_option_conv($fields [$k] ['data']);
                            break;
                        case 'richtext' :
                            $fields [$k] ['value'] = $model_data [$k];
                            break;
                        case 'imagefile' :
                            $fields [$k] ['value'] = $model_data [$k];
                            if (!Storage::has($fields [$k] ['value'])) {
                                $fields [$k] ['value'] = __ROOT__ . '/asserts/image/none.png';
                            }
                            break;
                        case 'commonfile' :
                            $fields [$k] ['value'] = $model_data [$k];
                            break;
                        case 'treeparent':
                            $fields [$k] ['value'] = $model_data [$k];
                            $list = cms_treeparent_list($this->cms_table, $this->cms_pk, $fields[$k]['name'], $k, $fields[$k]['sort']);
                            $fields [$k] ['option'] = cms_treeparent_option($list, $this->cms_pk, $fields[$k]['name']);
                            break;
                        default :
                            $this->error('Unknown field ' . $fields [$k] ['type']);
                            break;
                    }
                }

                $this->addon_css = $addon_css;
                $this->addon_js = $addon_js;
                $this->addon_hjs = $addon_hjs;
                $this->fields = $fields;
                $this->id = $id;
                $this->page = $page;

                $this->display('Cms:add_edit');
                break;
            default :
                $this->error(L('error_request'));
        }
    }
}

function cms_field_option_conv($data)
{
    if (is_array($data)) {
        return $data;
    } else {
        $data_arr = explode('|', $data);
        $pid_name = '';
        if (count($data_arr) == 4) {
            list ($model, $vfield, $vtitle, $sort) = $data_arr;
        } else if (count($data_arr) == 5) {
            list ($model, $vfield, $vtitle, $sort, $pid_name) = $data_arr;
        }
        $arr = array();
        if ($pid_name) {
            $list = cms_treeparent_list($model, $vfield, $vtitle, $pid_name, $sort);
            $data_arr = cms_treeparent_option($list, $vfield, $vtitle);
            foreach ($data_arr as &$v) {
                $arr [$v [$vfield]] = $v [$vtitle];
            }
        } else {
            foreach (M($model)->order("$sort ASC")->field($vfield . ',' . $vtitle)->select() as $v) {
                $arr [$v [$vfield]] = $v [$vtitle];
            }
        }
        return $arr;
    }
}


function cms_tag_option_get($data)
{
    $arr = array();
    $tags = M('CmsTagPool')->order("updatetime Desc")->field('id,name')->where(array('cat' => $data))->select();
    if (!empty($tags)) {
        foreach ($tags as &$v) {
            $arr [$v ['id']] = $v ['name'];
        }
    }
    return $arr;
}


function cms_tag_ids2names($cat, $data)
{
    if (is_array($data)) {
        $data = join('', $data);
    }
    $all_tags = cms_tag_option_get($cat);
    $tags = array();
    foreach (explode('::', trim($data, ':')) as $id) {
        if (isset($all_tags[$id])) {
            $tags[] = $all_tags[$id];
        }
    }
    return $tags;
}

function cms_tag_names2ids($cat, $data)
{
    if (!is_array($data)) {
        $data = explode(',', $data);
    }
    $tags = array();
    foreach ($data as $tag) {
        $tag = trim($tag);
        if ($tag) {
            $tags[$tag] = true;
        }
    }
    $m = D('CmsTagPool');
    $tag_ids = array();
    foreach ($tags as $k => $v) {
        $one = $m->where(array('cat' => $cat, 'name' => $k))->find();
        if (empty($one)) {
            $id = $m->add(array('cat' => $cat, 'name' => $k, 'addtime' => time(), 'updatetime' => time()));
        } else {
            $id = $one['id'];
            $one['updatetime'] = time();
            $m->save($one);
        }
        $tag_ids[] = ":$id:";
    }
    return join('', $tag_ids);
}

function cms_field_option_valid($data, $value)
{
    if (!is_array($value)) {
        $value = array(
            $value
        );
    }
    $value = array_unique($value);
    if (!empty ($value)) {
        if (is_array($data)) {
            foreach ($value as $v) {
                if (!isset ($data [$v])) {
                    return false;
                }
            }
        } else {
            list ($model, $vfield, $vtitle) = explode('|', $data);
            $d = M($model)->field($vfield)->where(array(
                $vfield => array(
                    'IN',
                    $value
                )
            ))->select();
            if (count($d) != count($value)) {
                return false;
            }
        }
    }
    return true;
}

function cms_field_option_get_titles($data, $value)
{
    if (!is_array($value)) {
        $value = array(
            $value
        );
    }
    $value = array_unique($value);
    $rets = array();
    if (!empty ($value)) {
        if (is_array($data)) {
            foreach ($value as $v) {
                $rets [] = isset ($data [$v]) ? $data [$v] : $v;
            }
        } else {
            list ($model, $vfield, $vtitle) = explode('|', $data);
            foreach (M($model)->field($vtitle)->where(array(
                $vfield => array(
                    'IN',
                    $value
                )
            ))->select() as $v) {
                $rets [] = $v [$vtitle];
            }
        }
    }
    return $rets;
}

function cms_treeparent_option(&$list, $id, $title, $level = 0)
{
    $options = array();
    foreach ($list as &$r) {
        $options[] = array('id' => $r[$id], 'title' => '|-' . str_repeat("--", $level) . htmlspecialchars($r[$title]));
        if (!empty($r['_child'])) {
            $options = array_merge($options, cms_treeparent_option($r['_child'], $id, $title, $level + 1));
        }
    }
    return $options;
}

function cms_treeparent_list($table, $pk_name, $title_name, $pid_name = 'pid', $sort_name = 'sort')
{
    $datas = D($table)->field("$pk_name, $pid_name, $title_name")->select();
    if (is_array($datas)) {
        $datas = cms_treeparent_node_merge($datas, 0, $pk_name, $pid_name);
    } else {
        $datas = array();
    }
    return $datas;
}

function cms_treeparent_node_merge(&$node, $pid = 0, $pk_name = 'id', $pid_name = 'pid')
{
    $arr = array();

    foreach ($node as &$v) {
        if ($v [$pid_name] == $pid) {
            $v ['_child'] = cms_treeparent_node_merge($node, $v [$pk_name], $pk_name, $pid_name);
            $arr [] = $v;
        }
    }
    tpx_array_sort_by_key($arr, 'sort', 'asc');

    return $arr;
}

function cms_treeparent_option_valid($table, $pk_name, $value)
{
    $exists = D($table)->field($pk_name)->where(array($pk_name => $value))->find();
    if ($value != 0 && empty($exists)) {
        return false;
    }
    return true;
}

function cms_treeparent_changeable($table, $pk_name, $pid_name, $id, $value)
{
    // 新修改的子节点是该节点或者该节点的所有子孙节点，则不能修改
    $children_ids = cms_treeparent_child_ids($table, $pk_name, $pid_name, $id);
    if ($id == $value || in_array($value, $children_ids)) {
        return false;
    }
    return true;
}

function cms_treeparent_deleteable($table, $pk_name, $pid_name, $id)
{
    // 如果有子节点不能删除
    $children_ids = cms_treeparent_child_ids($table, $pk_name, $pid_name, $id);
    if (!empty($children_ids)) {
        return false;
    }
    return true;
}

function cms_treeparent_child_ids($table, $pk_name, $pid_name, $id)
{
    $datas = D($table)->field("$pk_name, $pid_name")->select();
    if (is_array($datas)) {
        $datas = cms_treeparent_node_merge($datas, $id, $pk_name, $pid_name);
    } else {
        $datas = array();
    }
    return cms_treeparent_child_ids_merge($datas, $pk_name);
}

function cms_treeparent_child_ids_merge(&$node, $pk_name)
{
    $ids = array();
    foreach ($node as &$v) {
        $ids [] = $v [$pk_name];
        if (!empty ($v ['_child'])) {
            $ids = array_merge($ids, cms_treeparent_child_ids_merge($v ['_child'], $pk_name));
        }
    }
    return $ids;
}