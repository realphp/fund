<?php

namespace Ext;


class MapUtil
{
    const MAP_TYPE_BAIDU = 1;       //百度地图
    const MAP_TYPE_QQ = 2;          //腾讯地区

    const NAVIGATE_TRANSIT = 1;     //公交
    const NAVIGATE_DRIVING = 2;     //驾车
    const NAVIGATE_WALKING = 3;     //步行


    /**
     * @param int $map_type
     * @param array $origin => array( 'name'=>'', 'lng'=>'', 'lat'=>'')
     * @param array $destination => array( 'name'=>'', 'lng'=>'', 'lat'=>'')
     */
    public static function web_navigate_redirect($map_type = self::MAP_TYPE_BAIDU, $destination = array(), $origin = array())
    {
        $url = '';

        switch (RequestUtil::source()) {
            default:
                $url_tpl = "intent://map/direction?origin=name:%s|latlng:%s,%s&destination=name:%s|latlng:%s,%s&mode=%s&src=TPX|TPX";
                $url = sprintf($url_tpl,
                    urlencode($destination['name']),
                    $destination['lat'],
                    $destination['lng'],
                    '', '', '', 'driving'
                );
                break;
        }


        header("Location: $url");
        exit();
    }
}