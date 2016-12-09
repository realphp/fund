<?php

namespace Home\Controller;


class EmptyController extends BaseController
{
    public function _empty()
    {
        if (file_exists($filename = './app/Home/Controller/Modules/EmptyControllerHandler.php')) {
            include $filename;
        } else {
            if (APP_DEBUG) {
                $this->e = array(
                    'message' => MODULE_NAME . ':' . CONTROLLER_NAME . ':' . ACTION_NAME . ' not exists !'
                );
            } else {
                $this->e = array(
                    'message' => C('ERROR_MESSAGE')
                );
            }
            $this->display('Common@Common:think_exception');
        }
    }
}