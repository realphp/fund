<?php

namespace Home\Controller;

use Think\Controller;

class BaseController extends Controller
{

    protected function _initialize()
    {

        if (!file_exists('./_CFG/install.lock')) {
            header('Location: ' . __ROOT__ . '/admin.php');
            exit();
        }

        tpx_upgrade_check();

    }
}