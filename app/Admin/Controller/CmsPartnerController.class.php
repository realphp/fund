<?php

namespace Admin\Controller;

class CmsPartnerController extends CmsController
{
    // 导出菜单
    // cmslist、cmshandle为必须要到导出的字段
    static $export_menu = array(
        'content' => array(
            '公益伙伴' => array(
                'cmslist' => array(
                    'title' => '伙伴列表',
                    'hiddens' => array(
                        'cmshandle' => '友情链接管理'
                    )
                ),
                'cmsadd' => array(
                    'title' => '添加伙伴',
                    'hiddens' => array()
                ),
            )
        )
    );
    // 标识字段，该字段为自增长字段
    public $cms_pk = 'id';
    // 数据表名称
    public $cms_table = 'cms_partner';
    // 数据库引擎
    public $cms_db_engine = 'MyISAM';
    // 列表列出的列出字段
    public $cms_fields_list = array(
        'id',
        'url',
        'name',
        'logo',
//        'type'
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
            'title' => '网址',
            'description' => '以http://开头',
            'type' => 'text',
            'length' => 200,
            'default' => 'http://',
            'rules' => 'required'
        ),

        'name' => array(
            'title' => '伙伴名称',
            'description' => '',
            'type' => 'text',
            'length' => 50,
            'default' => '',
            'rules' => 'required'
        ),

        'logo' => array(
            'title' => 'Logo',
            'description' => '上传png,jpg,gif文件',
            'type' => 'imagefile',
            'default' => '',
            'extension' => array(
                'jpg',
                'png',
                'gif'
            ),
            'rules' => ''
        ),
//        'type' => array(
//            'title' => '链接位置',
//            'description' => '',
//            'type' => 'selectnumber',
//            'data' => array(),
//            'default' => '1',
//            'rules' => 'searchable|required'
//        )
    );

    public function __construct()
    {
//        if (file_exists($file = 'app/Common/Custom/partner_type.php')) {
//            $this->cms_fields['type']['data'] = (include $file);
//        }
        parent::__construct();
    }

    public function cmsadd()
    {
        $this->cmshandle($action = 'add');
    }

}
