<?php

namespace Ext;


class NumberUtil
{
    public static function num2alpha($intNum, $isLower = false)
    {
        $num26 = base_convert($intNum, 10, 26);
        $addcode = $isLower ? 49 : 17;
        $result = '';
        for ($i = 0; $i < strlen($num26); $i++) {
            $code = ord($num26{$i});
            if ($code < 58) {
                $result .= chr($code + $addcode);
            } else {
                $result .= chr($code + $addcode - 39);
            }
        }
        return $result;
    }
}