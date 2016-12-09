<?php

namespace Admin\Controller;

use Think\Controller;

class PhotoController extends CmsController
{
    // 导出菜单
    // cmslist、cmshandle为必须要到导出的字段
    static $export_menu = array(
        'content' => array(
            '内容管理' => array(
                'page' => array(
                    'title' => '相册管理',
                    'hiddens' => array(
                        'cmshandle' => '相册管理'
                    )
                )
            )
        )
    );
    // 标识字段，该字段为自增长字段
    public $cms_pk = 'id';
    // 数据表名称
    public $cms_table = 'cms_album';
    // 数据库引擎
    public $cms_db_engine = 'MyISAM';
    // 列表列出的列出字段
    public $cms_fields_list = array(
        'id',
        'title',
        'cover',
        'created_time'
    );

    // 添加字段，留空表示所有字节均为添加项
    public $cms_fields_add = array();
    // 编辑字段，留空表示所有字节均为编辑项
    public $cms_fields_edit = array();
    // 搜索字段，表示列表搜索字段
    public $cms_fields_search = array('title');
    // 数据表字段
    public $cms_fields = array(
        'title' => array(
            'title' => '相册名',
            'type' => 'text',
            'length' => 15,
            'default' => '',
            'rules' => 'searchable|required'
        ),
        'cover' => array(
            'title' => '封面',
            'description' => '封面不能为空',
            'type' => 'imagefile',
            'default' => '',
            'extension' => array(
                'jpg',
                'png'
            ),
            'rules' => 'required'
        ),
        'created_time' => array(
            'title' => '创建时间',
            'type' => 'datetime',
            'default' => '0',
            'rules' => 'searchable|required'
        ),
        'description' => array(
            'title' => '相册描述(Description)',
            'type' => 'bigtext',
            'default' => '',
            'rules' => ''
        ),


    );


    public function page()
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

        $this->display('page');
    }


    public function photolist()
    {
        if (empty($_REQUEST['id'])) {
            $this->error('错误操作');
        }
        $list = M('cms_photo')->where('aid =' . intval($_REQUEST['id']))->order('id DESC')->select();
        $this->assign('list', $list);
        $this->display();
    }

    public function upload()
    {
        if (empty($_REQUEST['id'])) {
            return;
        }

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './data/image/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传（子）目录
        $upload->subName = date('Ym') . '/' . date('d'); // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功
            $path = 'data/image/' . $info['fileList']['savepath'] . $info['fileList']['savename'];
            $data['aid'] = $_REQUEST['id'];
            $data['path'] = $path;
            $data['uptime'] = time();
            $id = M('cms_photo')->add($data);
        }
    }

    public function del()
    {
        if (IS_AJAX) {
            if ($_REQUEST['id']) {
                $id = intval($_REQUEST['id']);
                $photo = M('cms_photo')->find($id);
                if($photo){
                    unlink($photo['path']);
                }
                M('cms_photo')->delete($id);
            }
        }
    }
}
