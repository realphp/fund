<?php

namespace Home\Controller;

class PartnerController extends BaseController
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

        $this->display();
    }




}