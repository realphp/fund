<?php

namespace Admin\Controller;

class ModConfigController extends ModController
{
//    static $export_menu = array(
//        'content' => array(
//            '网站设置' => array(
//                'basic' => array(
//                    'title' => '基本设置',
//                    'hiddens' => array()
//                ),
//                'contact' => array(
//                    'title' => '联系方式',
//                    'hiddens' => array()
//                ),
//                'counter' => array(
//                    'title' => '访问统计',
//                    'hiddens' => array()
//                ),
//                'domain' => array(
//                    'title' => '域名绑定',
//                    'hiddens' => array()
//                )
//            )
//        )
//    );

    public function domain()
    {
        if (IS_POST) {

            $apps = I('post.app', array());
            $domains = I('post.domain', array());

            $mapping = array();
            for ($i = 0; $i < count($apps); $i++) {
                $domain = isset($domains[$i]) ? $domains[$i] : '';
                $app = $apps[$i];
                if (!empty($domain) && !empty($app)) {
                    $mapping[$domain] = $app;
                }
            }

            tpx_sys_config_set('APP_SUB_DOMAIN_RULES', $mapping);

            $this->success('保存成功');
        }

        $domains = C('APP_SUB_DOMAIN_RULES');
        if (empty($domains)) {
            $domains = array();
        }

        $apps = array('Home' => '主程序');

        $this->data_apps = $apps;
        $this->data_domains = $domains;

        $this->display();
    }

    public function basic()
    {
        $keys = array(
            'home_title',
            'home_keywords',
            'home_description',
            'basic_copyright'
        );
        if (IS_POST) {
            // 伪静态开启检测
            foreach ($keys as &$k) {
                tpx_config($k, I('post.' . $k, '', 'trim'));
            }

            if (I('post.system_rewrite_enable', 0, 'intval')) {
                tpx_sys_config_set('URL_MODEL', 2);
            } else {
                tpx_sys_config_set('URL_MODEL', 3);
            }

            $this->success('保存成功');
        }

        foreach ($keys as &$k) {
            $this->$k = tpx_config_get($k, '');
        }

        $this->system_rewrite_enable = (tpx_sys_config_get('URL_MODEL') == 2);

        $this->display('ModConfig:basic');
    }

    public function counter()
    {
        $keys = array(
            'code_counter_position',
            'code_counter',
        );
        if (IS_POST) {
            foreach ($keys as &$k) {
                tpx_config($k, I('post.' . $k, '', 'trim'));
            }
            $this->success('保存成功');
        }

        foreach ($keys as &$k) {
            $this->$k = tpx_config($k);
        }

        $this->display('ModConfig:counter');
    }

    public function contact()
    {
        $keys = array(
            'contact_address',
            'contact_email',
            'contact_website',
            'contact_tel',
            'contact_qq'
        );
        if (IS_POST) {
            $data = array();
            foreach ($keys as &$k) {
                tpx_config($k, I('post.' . $k, '', 'trim'));
            }
            $this->success('保存成功');
        }

        foreach ($keys as &$k) {
            $this->$k = tpx_config($k);
        }

        $this->display('ModConfig:contact');
    }

}