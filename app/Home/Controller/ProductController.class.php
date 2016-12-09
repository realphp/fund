<?php

namespace Home\Controller;

class ProductController extends BaseController
{
    public function _empty($id = 0)
    {
        $pro_id = intval($id);
        $d = D('CmsProduct')->find($id);
        if (empty ($d)) {
            $this->redirect('/');
        }

        $d ['content'] = parse_res_url($d ['content'], __ROOT__ . '/', __ROOT__ . '/');

        $this->data_product = $d;

        $this->assign('page_title', $d ['title'] . ' - ' . tpx_config_get('home_title'));
        $this->assign('page_keywords', $d ['keywords']);
        $this->assign('page_description', $d['description']);
        $this->display('view');
    }

    public function index()
    {
        $this->page();
    }

    public function page($cat = 0, $p = 1)
    {
        $p = intval($p);
        $cat = intval($cat);

        $cat_data = null;
        if ($cat) {
            $cat_data = D('Product', 'Service')->cat($cat);
        }
        $this->cat_data = $cat_data;

        $where = array();
        if ($cat_data) {
            $where['cat'] = $cat;
        }

        $m = M('CmsProduct');

        $page = new \Think\Page ($m->where($where)->count(), 10);
        $page->setConfig('prev', '上页');
        $page->setConfig('next', '下页');
        $this->data_page = $page->show('page');

        $this->data_list = $m->where($where)->order('id desc')->field('id,title,cover,description')->page($p, 10)->select();

        $title = '全部产品';
        if ($cat_data) {
            $title = $cat_data['catname'];
        }
        $this->data_title = $title;

        $this->assign('page_title', $title . ' - ' . tpx_config_get('home_title'));
        $this->assign('page_keywords', $title . ' - ' . tpx_config_get('home_keywords'));
        $this->assign('page_description', $title . ' - ' . tpx_config_get('home_description'));
        $this->display('page');
    }
}