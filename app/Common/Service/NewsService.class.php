<?php

namespace Common\Service;

class NewsService
{
    public function latest($cache = 3600, $options = array('limit' => 6))
    {
        $flag = 'news/latest/' . md5($cache . serialize($options));
        $data = S($flag);
        if (false === $data) {
            $data = D('CmsNews')->order('id DESC')->limit($options ['limit'])->select();
            if (empty($data)) {
                $data = array();
            }
            S($flag, $data, $cache);
        }
        return $data;
    }
}