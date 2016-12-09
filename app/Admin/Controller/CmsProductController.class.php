<?php

namespace Admin\Controller;

class CmsProductController extends CmsController
{
    // 导出菜单
    // cmslist、cmshandle为必须要到导出的字段
//    static $export_menu = array(
//        'content' => array(
//            '内容管理' => array(
//                'cmslist' => array(
//                    'title' => '产品中心',
//                    'hiddens' => array(
//                        'cmshandle' => '产品管理'
//                    )
//                )
//            )
//        )
//    );
    // 标识字段，该字段为自增长字段
    public $cms_pk = 'id';
    // 数据表名称
    public $cms_table = 'cms_product';
    // 数据库引擎
    public $cms_db_engine = 'MyISAM';
    // 列表列出的列出字段
    public $cms_fields_list = array(
        'id',
        'cat',
        'title',
        'cover'
    );
    // 添加字段，留空表示所有字节均为添加项
    public $cms_fields_add = array();
    // 编辑字段，留空表示所有字节均为编辑项
    public $cms_fields_edit = array();
    // 搜索字段，表示列表搜索字段
    public $cms_fields_search = array();
    // 数据表字段
    public $cms_fields = array(
        'cat' => array(
            'title' => '产品分类',
            'description' => '可以在产品分类中增加或修改',
            'type' => 'selecttext',
            'length' => '200',
            'data' => 'cms_product_cat|id|catname|sort',
            'default' => '0',
            'rules' => 'searchable|required'
        ),
        'recommend' => array(
            'title' => '首页推荐',
            'description' => '推荐产品将会显示在首页',
            'type' => 'switch',
            'default' => '0',
            'rules' => 'searchable'
        ),
        'title' => array(
            'title' => '产品名称',
            'description' => '',
            'type' => 'text',
            'length' => 200,
            'default' => '',
            'rules' => 'searchable|required'
        ),
        'keywords' => array(
            'title' => '产品关键词(Keywords)',
            'description' => '留空则使用标题',
            'type' => 'text',
            'length' => 200,
            'default' => '',
            'rules' => 'searchable'
        ),
        'description' => array(
            'title' => '产品描述(Description)',
            'description' => '留空则自动截取正文前80字',
            'type' => 'bigtext',
            'default' => '',
            'rules' => ''
        ),
        'price' => array(
            'title' => '产品价格',
            'description' => '填写0则不显示价格',
            'type' => 'number',
            'default' => '0',
            'rules' => 'searchable|unsigned'
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
        'content' => array(
            'title' => '内容',
            'description' => '',
            'type' => 'richtext',
            'rules' => 'required'
        )
    );
}
