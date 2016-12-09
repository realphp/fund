<?php

namespace Ext;

class RequestUtil
{
    // 来源判断
    const SOURCE_ANDROID = 1;
    const SOURCE_IOS = 2;
    const SOURCE_WEB = 3;
    const SOURCE_WECHAT = 4;

    public static function source()
    {
        $source = self::SOURCE_WEB;
        $agent = I('server.HTTP_USER_AGENT', '', 'strtolower');

        if (strpos($agent, 'micromessenger')) {
            $source = self::SOURCE_WECHAT;
        } else if (strpos($agent, 'android')) {
            $source = self::SOURCE_ANDROID;
        } else if (strpos($agent, 'iphone') || strpos($agent, 'ipad')) {
            $source = self::SOURCE_IOS;
        }
        return $source;
    }

}