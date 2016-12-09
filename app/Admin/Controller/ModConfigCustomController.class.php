<?php

namespace Admin\Controller;

class ModConfigCustomController extends ModController
{
//    static $export_menu = array(
//        'content' => array(
//            '网站设置' => array(
//                'index' => array(
//                    'title' => '其他设置',
//                    'hiddens' => array()
//                ),
//            )
//        )
//    );

    public function index()
    {
        $keys = array(
            'home_about',
            'image_logo',
            'image_qr',
            'theme_color'
        );
        if (IS_POST) {
            foreach ($keys as &$k) {
                tpx_config($k, I('post.' . $k, '', 'trim'));
            }
            foreach (array('image_logo', 'image_qr') as $img) {
                $old = tpx_config_get($img);
                $new = upload_tempfile_save_storage('image', $old);
                if ($new) {
                    tpx_config($img, 'data/image/' . $new);
                }
            }
            $this->success('保存成功');
        }

        foreach ($keys as &$k) {
            $this->$k = tpx_config_get($k);
        }
        $this->image_logo = tpx_config_get('image_logo', 'asserts/res/image/logo.png');
        $this->image_qr = tpx_config_get('image_qr', 'asserts/res/image/qr.jpg');

        $this->display();
    }

}