<?php

namespace Home\Controller;

use Think\Controller;
use Think\Log;

class WatcherController extends Controller
{
    protected function _initialize()
    {
    }

    public function index()
    {

    }

    public function auto_deploy()
    {
        if (file_exists($file = './app/Home/Controller/Modules/WatcherAutoDeploy.php')) {
            if (include($file)) {
                echo 'SUCCESS';
                return;
            }
        }
        echo 'FAILED';
    }

    public function js()
    {
        $file = I('get.file', '', 'trim');
        $line = I('get.line', '', 'trim');
        $error = I('get.error', '', 'trim');
        $url = I('get.url', '', 'trim');
        $agent = I('get.agent', '', 'trim');

        $_SERVER['REQUEST_URI'] = __ROOT__ . '/watcher/js';
        Log::record("Url=$url, File=$file, Line=$line, Error=$error, Agent=$agent");

    }


}
