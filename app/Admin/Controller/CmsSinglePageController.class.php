<?php

namespace Admin\Controller;

class CmsSinglePageController extends CmsController
{
    // 导出菜单
    // cmslist、cmshandle为必须要到导出的字段
//    static $export_menu = array(
//        'content' => array(
//            '单页管理' => array(
//                'cmslist' => array(
//                    'title' => '单页列表',
//                    'hiddens' => array(
//                        'cmshandle' => '单页管理'
//                    )
//                )
//            )
//        )
//    );
    // 标识字段，该字段为自增长字段
    public $cms_pk = 'id';
    // 数据表名称
    public $cms_table = 'cms_single_page';
    // 数据库引擎
    public $cms_db_engine = 'MyISAM';
    // 列表列出的列出字段
    public $cms_fields_list = array(
        'id',
        'title',
        'url'
    );
    // 添加字段，留空表示所有字节均为添加项
    public $cms_fields_add = array();
    // 编辑字段，留空表示所有字节均为编辑项
    public $cms_fields_edit = array();
    // 搜索字段，表示列表搜索字段
    public $cms_fields_search = array();
    // 数据表字段
    public $cms_fields = array(
        'url' => array(
            'title' => '访问URL路径',
            'description' => '除了news,product以外单词',
            'type' => 'text',
            'length' => 200,
            'default' => '',
            'rules' => 'searchable|required'
        ),
        'show_in_nav' => array(
            'title' => '导航显示',
            'description' => '',
            'type' => 'switch',
            'default' => '1',
            'rules' => ''
        ),
        'title' => array(
            'title' => '页面标题',
            'description' => '',
            'type' => 'text',
            'length' => 200,
            'default' => '',
            'rules' => 'searchable|required'
        ),
        'keywords' => array(
            'title' => '页面关键词(Keywords)',
            'description' => '留空则使用标题',
            'type' => 'text',
            'length' => 200,
            'default' => '',
            'rules' => 'searchable'
        ),
        'description' => array(
            'title' => '页面描述(Description)',
            'description' => '留空则自动截取正文前80字',
            'type' => 'bigtext',
            'default' => '',
            'rules' => ''
        ),
        'content' => array(
            'title' => '内容',
            'description' => '',
            'type' => 'richtext',
            'rules' => 'required'
        ),
    );

    public function __construct()
    {
        if (file_exists($file = 'app/Common/Custom/cms_single_page.php')) {
            $cfg = (include $file);
            $this->cms_fields['url']['description'] = $cfg['url']['description'];
        }
        parent::__construct();
    }

    protected function field_process_view($field, $data, &$data_all = null)
    {
        switch ($field) {
            case 'url':
                return '<a target="_blank" href="' . __ROOT__ . '/' . $data . '">' . $data . '</a>';
        }
        return $data;
    }
}
