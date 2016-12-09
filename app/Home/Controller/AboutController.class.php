<?php

namespace Home\Controller;


class AboutController extends BaseController
{
    public function index()
    {
        $this->assign('title','关于我们');
        $this->display();
    }

    public function contact()
    {
        $this->display();
    }

    public function welfare()
    {
        $this->display();
    }
}