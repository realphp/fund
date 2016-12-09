<?php

namespace Common\Service;

class ProductService
{
    public function recommend($cache = 3600, $options = array('limit' => 999))
    {
        $flag = 'product/recommend/' . md5($cache . serialize($options));
        $data = S($flag);
        if (false === $data) {
            $data = D('CmsProduct')->order('id ASC')->where(array('recommend' => 1))->limit($options ['limit'])->select();
            if (empty($data)) {
                $data = array();
            }
            S($flag, $data, $cache);
        }
        return $data;
    }

    public function catlist($cache = 3600, $options = array('limit' => 999))
    {
        $flag = 'product/catlist/' . md5($cache . serialize($options));
        $data = S($flag);
        if (false === $data) {
            $data = D('CmsProductCat')->order('sort ASC')->limit($options ['limit'])->select();
            if (empty($data)) {
                $data = array();
            }
            S($flag, $data, $cache);
        }
        return $data;
    }

    public function cat($cat, $cache = 3600, $options = array('limit' => 999))
    {
        $flag = 'product/cat/' . $cat . '/' . md5($cache . serialize($options));
        $data = S($flag);
        if (false === $data) {
            $data = D('CmsProductCat')->where(array('id' => $cat))->find();
            if (empty($data)) {
                $data = array();
            }
            S($flag, $data, $cache);
        }
        return $data;
    }


}