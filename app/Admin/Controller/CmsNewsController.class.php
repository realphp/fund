<?php

namespace Admin\Controller;

class CmsNewsController extends CmsController
{
    // 导出菜单
    // cmslist、cmshandle为必须要到导出的字段
    static $export_menu = array(
        'content' => array(
            '内容管理' => array(
                'cmslist' => array(
                    'title' => '新闻动态',
                    'hiddens' => array(
                        'cmshandle' => '新闻动态管理'
                    )
                )
            )
        )
    );
    // 标识字段，该字段为自增长字段
    public $cms_pk = 'id';
    // 数据表名称
    public $cms_table = 'cms_news';
    // 数据库引擎
    public $cms_db_engine = 'MyISAM';
    // 列表列出的列出字段
    public $cms_fields_list = array(
        'id',
        'title',
        'posttime'
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
            'title' => '新闻标题',
            'description' => '',
            'type' => 'text',
            'length' => 200,
            'default' => '',
            'rules' => 'searchable|required'
        ),
        'posttime' => array(
            'title' => '发布时间',
            'description' => '说明',
            'type' => 'datetime',
            'default' => '0',
            'rules' => 'searchable|required'
        ),
        'keywords' => array(
            'title' => '新闻关键词(Keywords)',
            'description' => 'SEO优化使用，最好可以填写',
            'type' => 'text',
            'length' => 200,
            'default' => '',
            'rules' => 'searchable'
        ),
        'description' => array(
            'title' => '新闻描述(Description)',
            'description' => 'SEO优化使用，最好可以填写',
            'type' => 'bigtext',
            'default' => '',
            'rules' => ''
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
        ),
    );


}
