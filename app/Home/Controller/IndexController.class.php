<?php

namespace Home\Controller;


class IndexController extends BaseController
{
    public function index2()
    {

        print_r(C('TMPL_PARSE_STRING.'));

        $this->page_title = tpx_config_get('home_title');
        $this->page_keywords = tpx_config_get('home_keywords');
        $this->page_description = tpx_config_get('home_description');
        $this->display();
    }
    public function index(){
        $news =  M('cms_news')->order('id DESC')->limit(6)->select();
        $articles = M('cms_articles')->order('id DESC')->limit(8)->select();
        $this->assign('articles',$articles);
        $this->assign('news',$news);
        $this->display();
    }
}