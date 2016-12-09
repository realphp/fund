<?php

namespace Home\Controller;

class NewsController extends BaseController
{
    public function _empty($new_id = 0)
    {
        $pro_id = intval($new_id);
        $d = D('CmsNews')->find($new_id);
        if (empty ($d)) {
            $this->redirect('/');
        }

        $d ['content'] = parse_res_url($d ['content'], __ROOT__ . '/', __ROOT__ . '/');

        $this->data_news = $d;

        $this->assign('page_title', $d ['title'] . ' - ' . tpx_config_get('home_title'));
        $this->assign('page_keywords', $d ['keywords']);
        $this->assign('page_description', $d['description']);
        $this->display('view');
    }

    public function index()
    {
        $this->page();
    }

    public function page($p = 1)
    {
        $p = intval($p);

        $m = M('CmsNews');

        $page = new \Think\Page ($m->count(), 5);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $this->data_page = $page->show('page');

        $this->data_news = $m->order('id desc')->field('id,title,posttime,description,cover')->page($p, 5)->select();

        $this->assign('page_title', '新闻动态 - ' . tpx_config_get('home_title'));
        $this->assign('page_keywords', '新闻动态 - ' . tpx_config_get('home_keywords'));
        $this->assign('page_description', '新闻动态 - ' . tpx_config_get('home_description'));
        $this->display('page');
    }



}