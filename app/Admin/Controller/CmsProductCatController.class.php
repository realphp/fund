<?php

namespace Admin\Controller;

class CmsProductCatController extends CmsController
{
    // 导出菜单
    // cmslist、cmshandle为必须要到导出的字段
//    static $export_menu = array(
//        'content' => array(
//            '内容管理' => array(
//                'cmslist' => array(
//                    'title' => '产品分类',
//                    'hiddens' => array(
//                        'cmshandle' => '产品分类管理',
//                    )
//                )
//            )
//        )
//    );
    // 标识字段，该字段为自增长字段
    public $cms_pk = 'id';
    // 数据表名称
    public $cms_table = 'cms_product_cat';
    // 数据库引擎
    public $cms_db_engine = 'MyISAM';
    // 列表列出的列出字段
    public $cms_fields_list = array(
        'id',
        'catname',
        'sort',
    );
    // 添加字段，留空表示所有字节均为添加项
    public $cms_fields_add = array();
    // 编辑字段，留空表示所有字节均为编辑项
    public $cms_fields_edit = array();
    // 搜索字段，表示列表搜索字段
    public $cms_fields_search = array();
    // 数据表字段
    public $cms_fields = array(
        'catname' => array(
            'title' => '分类名称',
            'description' => '必须填写',
            'type' => 'text',
            'length' => 50,
            'default' => '',
            'rules' => 'searchable|unique|required'
        ),
        'sort' => array(
            'title' => '显示顺序',
            'description' => '数字越小越靠前',
            'type' => 'number',
            'default' => '999',
            'rules' => 'searchable|required|unsigned'
        ),
    );
}
