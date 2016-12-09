<?php

namespace Admin\Controller;

use Think\Verify;

class LoginController extends AdminController
{
    public function index()
    {
        if (ADMIN_UID) {
            header('Location: ' . U('System/info'));
            return;
        }
        define('ADMIN_EMPTY_FRAME', true);
        define('ADMIN_EMPTY_TITLE', L('login'));
        $this->display();
    }

    public function verify()
    {
        if (ADMIN_UID) {
            header('Location: ' . U('System/info'));
            return;
        }
        $verify = new Verify ();
        $verify->length = 4;
        $verify->entry('admin_login');
    }

    public function out()
    {
        if (!ADMIN_UID) {
            header('Location: ' . U('System/info'));
            return;
        }
        session(C('USER_AUTH_KEY'), 0);
        session('admin_username', null);
        session('admin_last_login_time', 0);
        session('admin_last_login_ip', 0);
        header('Location: ' . U('System/info'));
    }

    public function submit()
    {
        if (ADMIN_UID) {
            header('Location: ' . U('System/info'));
            return;
        }
        if (!IS_POST) {
            $this->error(L('error_request'));
        }
        $verify = new Verify ();
        if (!$verify->check(I('post.verify'), 'admin_login')) {
            $this->error(L('verify_error'));
        }

        $username = I('post.username');
        $password = I('post.password');

        $admin = M('admin_user')->where(array(
            'username' => $username
        ))->find();

        if (!$admin || $admin ['password'] != encrypt_password($password, $admin ['password_salt'])) {
            $this->error(L('login_failed'));
        }

        switch (intval($admin ['status'])) {
            case 0 :
                $this->error(L('user_locked'));
                break;
        }

        $data = array(
            'id' => $admin ['id'],
            'last_login_time' => time(),
            'last_login_ip' => get_client_ip(1, true)
        );
        M('admin_user')->save($data);

        session('admin_weak_pwd', false);
        $weak_pwd_reg = array(
            '/^[0-9]{0,6}$/',
            '/^[a-z]{0,6}$/',
            '/^[A-Z]{0,6}$/'
        );
        foreach ($weak_pwd_reg as $reg) {
            if (preg_match($reg, $password)) {
                session('admin_weak_pwd', true);
                break;
            }
        }

        session(C('USER_AUTH_KEY'), $admin ['id']);
        session('admin_username', $admin ['username']);
        session('admin_last_login_time', $admin ['last_login_time']);
        session('admin_last_login_ip', $admin ['last_login_ip']);
        session('admin_last_change_pwd_time', $admin ['last_change_pwd_time']);
        $this->success('', U('System/info'));
    }
}