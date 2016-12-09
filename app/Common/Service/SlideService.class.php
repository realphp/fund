<?php

namespace Common\Service;

class SlideService
{
    public function all($cache = 3600, $options = array('limit' => 999))
    {
        $flag = 'slide/all/' . md5($cache . serialize($options));
        $data = S($flag);
        if (false === $data) {
            $data = D('CmsSlide')->order('id ASC')->limit($options ['limit'])->select();
            if (empty($data)) {
                $data = array();
            }
            S($flag, $data, $cache);
        }
        return $data;
    }
}