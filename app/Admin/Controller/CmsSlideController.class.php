<?php

namespace Admin\Controller;

class CmsSlideController extends CmsController
{
    // 导出菜单
    // cmslist、cmshandle为必须要到导出的字段
    static $export_menu = array(
        'content' => array(
            '网站设置' => array(
                'cmslist' => array(
                    'title' => '首页大图',
                    'hiddens' => array(
                        'cmshandle' => '首页大图管理'
                    )
                )
            )
        )
    );
    // 标识字段，该字段为自增长字段
    public $cms_pk = 'id';
    // 数据表名称
    public $cms_table = 'cms_slide';
    // 数据库引擎
    public $cms_db_engine = 'MyISAM';
    // 列表列出的列出字段
    public $cms_fields_list = array(
        'id',
        'title',
        'image'
    );
    // 添加字段，留空表示所有字节均为添加项
    public $cms_fields_add = array();
    // 编辑字段，留空表示所有字节均为编辑项
    public $cms_fields_edit = array();
    // 搜索字段，表示列表搜索字段
    public $cms_fields_search = array();
    // 数据表字段
    public $cms_fields = array(
        'title' => array(
            'title' => '标题',
            'description' => '标题可以为空',
            'type' => 'text',
            'length' => 200,
            'default' => '',
            'rules' => ''
        ),
        'image' => array(
            'title' => '本地图片',
            'description' => '所有图片尺寸必须相同，PNG格式',
            'type' => 'imagefile',
            'default' => '',
            'extension' => array(
                'png'
            ),
            'rules' => 'required'
        ),
        'url' => array(
            'title' => '跳转链接',
            'description' => '可选',
            'type' => 'text',
            'length' => 300,
            'default' => '',
            'rules' => ''
        ),
    );
}
