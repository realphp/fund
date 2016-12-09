<?php

namespace Admin\Controller;

use Think\Controller;

class AdminController extends Controller
{
    protected function _initialize()
    {
        if (file_exists($file = './app/Common/Custom/app_env_config.php')) {
            include $file;
        }

        tpx_upgrade_check();

        if (!defined('ADMIN_PERMISSION_CHECK_IGNORE')) {
            if (defined('ADMIN_UID')) {
                return;
            }
            define ('ADMIN_UID', I('session.' . C('USER_AUTH_KEY'), 0));


            // check installition
            if (CONTROLLER_NAME != 'Install' && (!file_exists('./_CFG/install.lock'))) {
                $this->redirect('Install/index');
            }
            // check auth
            if (!in_array(CONTROLLER_NAME, array(
                'Install',
                'Login'
            ))
            ) {

                if (!ADMIN_UID) {
                    $this->redirect('Login/index');
                }
                if (!access_permit()) {
                    if (CONTROLLER_NAME == 'System' && ACTION_NAME == 'info') {
                        // permit for basic info
                    } else {
                        $this->error(L('access_permissions'), U('Login/out'));
                    }
                }
            }

        }
    }

    public function _empty($name)
    {
        $this->error(L('error_request'));
    }
}